<?php

/**
 * Comprehensive input sanitization function
 * Handles XSS prevention, SQL injection basics, and general data cleaning
 * 
 * @param string|array $input The user input to sanitize (string or array of strings)
 * @param array $options Configuration options
 * @return string|array Sanitized input (same type as input)
 */
function sanitizeInput($input, $options = []) {
    // Handle array inputs
    if (is_array($input)) {
        return array_map(function($item) use ($options) {
            return sanitizeInput($item, $options);
        }, $input);
    }
    
    // Default options
    $config = array_merge([
        'allowHTML' => false,
        'trimWhitespace' => true,
        'maxLength' => 1000,
        'allowSpecialChars' => true
    ], $options);
    
    // Handle null or non-string inputs
    if (!is_string($input)) {
        return '';
    }
    
    $sanitized = $input;
    
    // Trim whitespace if requested
    if ($config['trimWhitespace']) {
        $sanitized = trim($sanitized);
    }
    
    // Enforce maximum length
    if (strlen($sanitized) > $config['maxLength']) {
        $sanitized = substr($sanitized, 0, $config['maxLength']);
    }
    
    // HTML/XSS protection
    if (!$config['allowHTML']) {
        // Escape HTML entities
        $sanitized = htmlspecialchars($sanitized, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    } else {
        // If HTML is allowed, only escape the most dangerous characters
        $sanitized = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/i', '', $sanitized);
        $sanitized = preg_replace('/javascript:/i', '', $sanitized);
        $sanitized = preg_replace('/on\w+\s*=/i', '', $sanitized);
    }
    
    // SQL Injection basic protection (escape single quotes)
    $sanitized = str_replace("'", "''", $sanitized);
    
    // Remove or escape potentially dangerous characters if not allowed
    if (!$config['allowSpecialChars']) {
        // Keep only alphanumeric, spaces, and basic punctuation
        $sanitized = preg_replace('/[^a-zA-Z0-9\s\.,\-_!?]/', '', $sanitized);
    }
    
    // Remove null bytes and control characters
    $sanitized = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $sanitized);
    
    // Remove excessive whitespace (multiple spaces/tabs/newlines become single space)
    $sanitized = preg_replace('/\s+/', ' ', $sanitized);
    
    return $sanitized;
}

/**
 * Sanitize input for email addresses
 * 
 * @param string|array $email Email address(es) to sanitize
 * @return string|array Sanitized email(s)
 */
function sanitizeEmail($email) {
    // Handle array inputs
    if (is_array($email)) {
        return array_map('sanitizeEmail', $email);
    }
    
    if (!is_string($email)) {
        return '';
    }
    
    $sanitized = strtolower(trim($email));
    
    // Only allow valid email characters
    $sanitized = preg_replace('/[^a-z0-9@.\-_+]/', '', $sanitized);
    
    // RFC 5321 limit
    return substr($sanitized, 0, 254);
}

/**
 * Sanitize input for usernames/IDs
 * 
 * @param string|array $username Username(s) to sanitize
 * @return string|array Sanitized username(s)
 */
function sanitizeUsername($username) {
    // Handle array inputs
    if (is_array($username)) {
        return array_map('sanitizeUsername', $username);
    }
    
    if (!is_string($username)) {
        return '';
    }
    
    $sanitized = trim($username);
    
    // Only alphanumeric, underscore, hyphen
    $sanitized = preg_replace('/[^a-zA-Z0-9_\-]/', '', $sanitized);
    
    // Reasonable length limit
    return substr($sanitized, 0, 30);
}

/**
 * Sanitize numeric input
 * 
 * @param string|array|number $input Numeric input(s) to sanitize
 * @param array $options Configuration options
 * @return float|int|null|array Sanitized number(s)
 */
function sanitizeNumber($input, $options = []) {
    // Handle array inputs
    if (is_array($input)) {
        return array_map(function($item) use ($options) {
            return sanitizeNumber($item, $options);
        }, $input);
    }
    
    $config = array_merge([
        'allowFloat' => true,
        'allowNegative' => true,
        'min' => null,
        'max' => null
    ], $options);
    
    if (is_numeric($input)) {
        $input = (string)$input;
    }
    
    if (!is_string($input)) {
        return null;
    }
    
    // Remove non-numeric characters (keep digits, decimal point, minus)
    $sanitized = preg_replace('/[^0-9.\-]/', '', $input);
    
    // Handle float/integer
    if (!$config['allowFloat']) {
        $sanitized = str_replace('.', '', $sanitized);
    } else {
        // Ensure only one decimal point
        $parts = explode('.', $sanitized);
        if (count($parts) > 2) {
            $sanitized = $parts[0] . '.' . implode('', array_slice($parts, 1));
        }
    }
    
    // Handle negative numbers
    if (!$config['allowNegative']) {
        $sanitized = str_replace('-', '', $sanitized);
    } else {
        // Ensure minus sign is only at the beginning
        $hasNegative = strpos($input, '-') === 0;
        $sanitized = str_replace('-', '', $sanitized);
        if ($hasNegative) {
            $sanitized = '-' . $sanitized;
        }
    }
    
    if (!is_numeric($sanitized)) {
        return null;
    }
    
    $num = $config['allowFloat'] ? (float)$sanitized : (int)$sanitized;
    
    // Apply min/max constraints
    if ($config['min'] !== null && $num < $config['min']) {
        return $config['min'];
    }
    if ($config['max'] !== null && $num > $config['max']) {
        return $config['max'];
    }
    
    return $num;
}

/**
 * Sanitize input using PHP's filter_var with multiple filters
 * 
 * @param string|array $input Input to sanitize
 * @param int $filter PHP filter constant (default: FILTER_SANITIZE_STRING)
 * @param mixed $options Filter options
 * @return string|array|false Sanitized input or false on failure
 */
function sanitizeWithFilter($input, $filter = FILTER_SANITIZE_FULL_SPECIAL_CHARS, $options = null) {
    // Handle array inputs
    if (is_array($input)) {
        return array_map(function($item) use ($filter, $options) {
            return sanitizeWithFilter($item, $filter, $options);
        }, $input);
    }
    
    return filter_var($input, $filter, $options);
}

/**
 * Comprehensive sanitization for common web inputs
 * 
 * @param array $data Associative array of input data
 * @param array $rules Sanitization rules for each field
 * @return array Sanitized data
 */
function sanitizeFormData($data, $rules = []) {
    $sanitized = [];
    
    foreach ($data as $key => $value) {
        $rule = isset($rules[$key]) ? $rules[$key] : 'default';
        
        switch ($rule) {
            case 'email':
                $sanitized[$key] = sanitizeEmail($value);
                break;
            case 'username':
                $sanitized[$key] = sanitizeUsername($value);
                break;
            case 'number':
                $sanitized[$key] = sanitizeNumber($value);
                break;
            case 'int':
                $sanitized[$key] = sanitizeNumber($value, ['allowFloat' => false]);
                break;
            case 'url':
                $sanitized[$key] = filter_var($value, FILTER_SANITIZE_URL);
                break;
            case 'html':
                $sanitized[$key] = sanitizeInput($value, ['allowHTML' => true]);
                break;
            case 'none':
                $sanitized[$key] = $value; // No sanitization
                break;
            default:
                $sanitized[$key] = sanitizeInput($value);
                break;
        }
    }
    
    return $sanitized;
}



?>
 // Function to use external files in same directory
        function switchForm(page) {
            // Hide welcome content and dynamic content
            document.getElementById('welcome-content').style.display = 'none';
            document.getElementById('dynamic-content').style.display = 'none';
            
            // Show loading indicator
            document.getElementById('loading-indicator').style.display = 'flex';
            document.getElementById('formIframe').style.display = 'none';

            const iframe = document.getElementById('formIframe');
            
            iframe.onload = function() {
                document.getElementById('loading-indicator').style.display = 'none';
                iframe.style.display = 'block';
            };
            
            
            iframe.src = page;
        }

        // Function to update active button state
        function updateActiveButton(clickedButton) {
            document.querySelectorAll('.sidebar-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            clickedButton.classList.add('active');
        }

        // Add event listeners for sidebar buttons
        document.querySelectorAll('.sidebar-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                updateActiveButton(this);
            });
        });

        // Add event listeners for mobile navigation buttons
        document.querySelectorAll('.mobile-nav-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const navbarCollapse = document.getElementById('navbarNav');
                const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                    hide: true
                });
                bsCollapse.hide();
            });
        });

        // Load welcome message by default (not home content)
        document.addEventListener('DOMContentLoaded', function() {
            // Dashboard starts with welcome message
            // Users need to click buttons to load pages
        });
    
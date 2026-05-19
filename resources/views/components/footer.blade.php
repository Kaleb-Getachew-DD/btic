<footer class="footer">
    <div class="container">
        <div class="footer-grid">

            {{-- Brand --}}
            <div>
                <div class="footer-brand-logo">
                    <x-site-logo variant="footer" />
                    <div>
                        <div class="footer-brand-name">DDU BTIC</div>
                        <div class="footer-brand-sub">Incubation Center</div>
                    </div>
                </div>
                <p class="footer-desc">
                    Dire Dawa University Business and Technology Incubation Center empowers entrepreneurs to build innovative, scalable startups that transform Ethiopia and East Africa.
                </p>
                <div class="footer-socials">
                    @if(\App\Models\Setting::get('facebook_url'))
                        <a href="{{ \App\Models\Setting::get('facebook_url') }}" class="footer-social" target="_blank" rel="noopener">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                    @if(\App\Models\Setting::get('twitter_url'))
                        <a href="{{ \App\Models\Setting::get('twitter_url') }}" class="footer-social" target="_blank" rel="noopener">
                            <i class="fab fa-twitter"></i>
                        </a>
                    @endif
                    @if(\App\Models\Setting::get('linkedin_url'))
                        <a href="{{ \App\Models\Setting::get('linkedin_url') }}" class="footer-social" target="_blank" rel="noopener">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    @endif
                    @if(\App\Models\Setting::get('youtube_url'))
                        <a href="{{ \App\Models\Setting::get('youtube_url') }}" class="footer-social" target="_blank" rel="noopener">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="footer-heading">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}" class="footer-link"><i class="fas fa-chevron-right" style="font-size:0.6rem"></i> Home</a></li>
                    <li><a href="{{ route('about') }}" class="footer-link"><i class="fas fa-chevron-right" style="font-size:0.6rem"></i> About BTIC</a></li>
                    <li><a href="{{ route('programs.index') }}" class="footer-link"><i class="fas fa-chevron-right" style="font-size:0.6rem"></i> Programs</a></li>
                    <li><a href="{{ route('startups.index') }}" class="footer-link"><i class="fas fa-chevron-right" style="font-size:0.6rem"></i> Our Startups</a></li>
                    <li><a href="{{ route('news.index') }}" class="footer-link"><i class="fas fa-chevron-right" style="font-size:0.6rem"></i> News & Events</a></li>
                    <li><a href="{{ route('apply.create') }}" class="footer-link"><i class="fas fa-chevron-right" style="font-size:0.6rem"></i> Apply Now</a></li>
                </ul>
            </div>

            {{-- Programs --}}
            <div>
                <h4 class="footer-heading">Programs</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('programs.index') }}" class="footer-link"><i class="fas fa-chevron-right" style="font-size:0.6rem"></i> Pre-Incubation</a></li>
                    <li><a href="{{ route('programs.index') }}" class="footer-link"><i class="fas fa-chevron-right" style="font-size:0.6rem"></i> Core Incubation</a></li>
                    <li><a href="{{ route('programs.index') }}" class="footer-link"><i class="fas fa-chevron-right" style="font-size:0.6rem"></i> Acceleration</a></li>
                    <li><a href="{{ route('programs.index') }}" class="footer-link"><i class="fas fa-chevron-right" style="font-size:0.6rem"></i> Graduate Support</a></li>
                    <li><a href="{{ route('contact.index') }}" class="footer-link"><i class="fas fa-chevron-right" style="font-size:0.6rem"></i> Mentorship</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="footer-heading">Contact Us</h4>
                <div>
                    <div class="footer-contact-item">
                        <i class="fas fa-map-marker-alt footer-contact-icon"></i>
                        <span>{{ \App\Models\Setting::get('contact_address', 'Dire Dawa University, P.O. Box 1362, Dire Dawa, Ethiopia') }}</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-phone footer-contact-icon"></i>
                        <span>{{ \App\Models\Setting::get('contact_phone', '+251 25 111 0000') }}</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-envelope footer-contact-icon"></i>
                        <span>{{ \App\Models\Setting::get('contact_email', 'btic@ddu.edu.et') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="footer-copyright">{{ \App\Models\Setting::get('footer_text', '© ' . date('Y') . ' Dire Dawa University BTIC. All rights reserved.') }}</p>
            <div class="footer-bottom-links">
                <a href="#" class="footer-bottom-link">Privacy Policy</a>
                <a href="#" class="footer-bottom-link">Terms of Use</a>
                <a href="{{ route('admin.login') }}" class="footer-bottom-link">Admin</a>
            </div>
        </div>
    </div>
</footer>

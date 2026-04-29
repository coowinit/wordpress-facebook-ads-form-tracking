<section class="portfolio-section portfolio-mixitup">
    <div class="auto-container">
        <div class="page-wrap">
            <div class="wizard-shell">
                <div class="stepper" id="stepper">
                    <div class="stepper-item is-active" data-step-indicator="1">
                        <div class="stepper-line"></div>
                        <div class="stepper-label">Home Owner or Installer?</div>
                    </div>
                    <div class="stepper-item" data-step-indicator="2">
                        <div class="stepper-line"></div>
                        <div class="stepper-label">Choose Samples</div>
                    </div>
                    <div class="stepper-item" data-step-indicator="3">
                        <div class="stepper-line"></div>
                        <div class="stepper-label">Leave Your Message</div>
                    </div>
                </div>
                <form id="sampleWizard" novalidate="">
                    <!-- Facebook 广告来源标记：访问链接包含 ?fb_ads=1 时，这里会自动变成 Yes -->
                    <input type="hidden" name="facebook_ads" id="facebook_ads" value="No">
                    <input type="hidden" name="first_landing_page" id="first_landing_page" value="">
                    <input type="hidden" name="fb_ads_landing_page" id="fb_ads_landing_page" value="">
                    <section class="step-panel is-active" data-step-panel="1">
                        <h2 class="section-title">Choose the most relevant option to receive tailored options to your needs.</h2>
                        <div class="selection-grid grid-3" id="identityGrid">
                            <button class="option-card" data-identity="home_owner" type="button">
                                <div class="option-visual">
                                    <img alt="" class="selected-corner-icon" src="<?php echo esc_url( get_theme_file_uri('images/circle-check.png') ); ?>"/> I am a<br/>Home Owner
                                </div>
                                <div class="option-copy is-empty" data-copy-slot="home_owner">
                                    <strong class="option-copy-title"></strong>
                                    <p class="option-copy-text"></p>
                                </div>
                            </button>
                            <button class="option-card" data-identity="professional_installer" type="button">
                                <div class="option-visual">
                                    <img alt="" class="selected-corner-icon" src="<?php echo esc_url( get_theme_file_uri('images/circle-check.png') ); ?>"/> I am a<br/>Professional Installer
                                </div>
                            </button>
                            <button class="option-card" data-identity="architect_designer" type="button">
                                <div class="option-visual">
                                    <img alt="" class="selected-corner-icon" src="<?php echo esc_url( get_theme_file_uri('images/circle-check.png') ); ?>"/> I am an<br/>Architect / Designer
                                </div>
                            </button>
                        </div>
                        <div class="validation-box" id="identityValidation">
                            <div class="error-text">Please select one identity before continuing.</div>
                        </div>
                        <div class="installer-extra" id="installerExtra">
                            <h3 style="margin:0 0 8px;font-size:20px;">For Professional Installers / Designers and or Architects</h3>
                            <div class="form-row">
                                <div class="field" id="field-abn">
                                    <label for="installerAbn">Enter your Australian Business Number (ABN) <span class="required-star">*</span></label>
                                    <input class="input" id="installerAbn" name="installer_abn" placeholder="e.g. 12 345 678 901" type="text"/>
                                    <div class="error-text">ABN is required for Professional Installer.</div>
                                </div>
                                <div class="field" id="field-business-name">
                                    <label for="installerBusinessName">Enter your Business Name <span class="required-star">*</span></label>
                                    <input class="input" id="installerBusinessName" name="installer_business_name" placeholder="e.g. ABC Decking Pty Ltd" type="text"/>
                                    <div class="error-text">Business name is required for Professional Installer.</div>
                                </div>
                            </div>
                        </div>
                        <div class="actions">
                            <div></div>
                            <div class="actions-right">
                                <button class="btn btn-primary" id="toStep2" type="button">Request Samples</button>
                            </div>
                        </div>
                    </section>
                    <section class="step-panel" data-step-panel="2">
                        <h2 class="section-title">Select your country / region and then choose products and colors.</h2>
                        <div class="selection-grid grid-3 region-head" id="regionGrid">
                            <button class="option-card" data-region="VIC" type="button">
                                <div class="option-visual">
                                <img alt="" class="selected-corner-icon" src="<?php echo esc_url( get_theme_file_uri('images/circle-check.png') ); ?>"/> VIC<br/>Australia
                                </div>
                                <div class="option-copy is-empty" data-region-copy="VIC">
                                <strong class="option-copy-title"></strong>
                                <p class="option-copy-text"></p>
                                </div>
                            </button>
                            <button class="option-card" data-region="QLD" type="button">
                                <div class="option-visual">
                                <img alt="" class="selected-corner-icon" src="<?php echo esc_url( get_theme_file_uri('images/circle-check.png') ); ?>"/> QLD<br/>Australia
                                </div>
                                <div class="option-copy is-empty" data-region-copy="QLD">
                                <strong class="option-copy-title"></strong>
                                <p class="option-copy-text"></p>
                                </div>
                            </button>
                            <button class="option-card" data-region="NSW" type="button">
                                <div class="option-visual">
                                <img alt="" class="selected-corner-icon" src="<?php echo esc_url( get_theme_file_uri('images/circle-check.png') ); ?>"/> NSW<br/>Australia
                                </div>
                                <div class="option-copy is-empty" data-region-copy="NSW">
                                <strong class="option-copy-title"></strong>
                                <p class="option-copy-text"></p>
                                </div>
                            </button>
                        </div>
                        <div class="validation-box" id="productValidation">
                            <div class="error-text">Please select a region, then choose at least one product and one color for each selected product.</div>
                        </div>
                        <div class="products-wrap" id="productsWrap">
                            <div class="product-list" id="productList"></div>
                        </div>
                        <div class="actions">
                            <div class="actions-right">
                                <button class="btn btn-secondary" id="backToStep1" type="button">Back</button>
                                <button class="btn btn-primary" id="toStep3" type="button">Continue</button>
                            </div>
                        </div>
                    </section>
                    <section class="step-panel" data-step-panel="3">
                        <h2 class="section-title">Leave Your Message <span class="required-star">*</span></h2>
                        <div class="summary-card">
                            <h3 class="summary-title">Selection Summary</h3>
                            <div class="summary-grid" id="summaryGrid"></div>
                        </div>
                        <div class="form-row">
                            <div class="field" id="field-first-name">
                                <label for="firstName">First Name <span class="required-star">*</span></label>
                                <input class="input" id="firstName" placeholder="First Name" type="text"/>
                                <div class="error-text">First name is required.</div>
                            </div>
                            <div class="field" id="field-last-name">
                                <label for="lastName">Last Name <span class="required-star">*</span></label>
                                <input class="input" id="lastName" placeholder="Last Name" type="text"/>
                                <div class="error-text">Last name is required.</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="field" id="field-phone">
                                <label for="phone">Phone <span class="required-star">*</span></label>
                                <input class="input" id="phone" placeholder="Phone number" type="tel"/>
                                <div class="error-text">Phone is required.</div>
                            </div>
                            <div class="field" id="field-email">
                                <label for="email">Email <span class="required-star">*</span></label>
                                <input class="input" id="email" placeholder="Email address" type="email"/>
                                <div class="error-text">A valid email is required.</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="field" id="field-address">
                                <label for="address">Address / Suburb <span class="required-star">*</span></label>
                                <input class="input" id="address" placeholder="City / suburb / state" type="text"/>
                                <div class="error-text">Address is required.</div>
                            </div>
                            <div class="field" id="field-street-address">
                                <label for="streetAddress">Street Address <span class="required-star">*</span></label>
                                <input class="input" id="streetAddress" placeholder="Street address" type="text"/>
                                <div class="error-text">Street address is required.</div>
                            </div>
                        </div>
                        <div class="field" id="field-message" style="margin-top:14px;">
                            <label for="message">Message</label>
                            <textarea class="textarea" id="message" placeholder="Tell us anything about your project, preferred colors, lead time or delivery requirements."></textarea>
                            <div class="error-text"></div>
                        </div>
                        <div class="field" id="field-consent" style="margin-top:16px;">
                            <label class="consent-row">
                                <input id="privacyConsent" type="checkbox"/>
                                <span>By clicking this, you consent to your personal information being collected, used and disclosed as set out in our Privacy Policy. <span class="required-star">*</span></span>
                            </label>
                            <div class="error-text">Please agree to the Privacy Policy before submitting.</div>
                        </div>
                        <div class="actions">
                            <div class="actions-right">
                                <button class="btn btn-secondary" id="backToStep2" type="button">Back</button>
                                <button class="btn btn-primary" id="submitWizard" type="submit">Submit Request</button>
                            </div>
                        </div>
                        <div class="result-box" id="resultBox">
                            <h4 class="result-title" id="resultTitle">Submission status</h4>
                            <div id="resultMessage"></div>
                            <div class="payload-preview" id="payloadPreview" style="display:none;"></div>
                        </div>
                    </section>
                </form>
            </div>
        </div>			
    </div>
</section>
	
<script>
    // 这样 JS 就能拿到主题目录
    window.evodekSampleRequest = {
        themeUrl: "<?php echo esc_url( get_theme_file_uri() ); ?>",
        ajaxUrl: "<?php echo esc_url( admin_url('admin-ajax.php') ); ?>",
        nonce: "<?php echo esc_attr( wp_create_nonce('evodek_sample_request_nonce') ); ?>"
    };
</script>
<?php
$sample_js_file = 'js/evodek-sample-request.js';
$sample_js_path = get_theme_file_path($sample_js_file);
$sample_js_ver  = file_exists($sample_js_path) ? filemtime($sample_js_path) : '1.0.6';
?>
<script src="<?php echo esc_url( get_theme_file_uri($sample_js_file) . '?v=' . $sample_js_ver ); ?>"></script>
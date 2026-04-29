<!--Contact Section-->
<section class="contact-section">
    <div class="auto-container">
        <div class="info-container mb-3">

            <!-- 表单 -->
            <form id="contactus" class="mb-4">
                <!-- 先在表单里加 nonce -->
                <?php wp_nonce_field('contact_us_nonce', 'contact_us_nonce'); ?>
                <h3 class="mb-2">Send Us a Message</h3>
                <p class="text-muted mb-4">
                    Fill out the form below and our team will reply to you shortly.
                </p>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Fullname*" required>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address*" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number*">
                    </div>
                    <div class="form-group col-md-6">
                        <select class="form-control" name="state" required>
                            <?php echo evodek_render_state_options(); ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-12">
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject*" required>
                    </div>
                </div>

                <div class="form-group">
                    <textarea class="form-control" id="message" name="message" placeholder="Message*" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <!-- 提交成功提示 -->
            <div id="formSuccess" class="alert alert-success mb-4" style="display:none;">
                Thank You! Your form has been submitted successfully. We’ll be in touch soon!
            </div>

        </div>
    </div>
</section>

<!-- Ajax表单提交 -->
<script>
    jQuery(function($){
        $('#contactus').on('submit', function(e){
            e.preventDefault();

            var $form = $(this);
            var $btn  = $form.find('button[type="submit"]');

            $('#formSuccess').hide();

            if ($btn.prop('disabled')) {
                return;
            }

            // 提交前再填充一次，确保隐藏字段已写入最新来源信息
            if (typeof window.evodekFillTrafficFields === 'function') {
                window.evodekFillTrafficFields();
            }

            var formData = $form.serializeArray();
            formData.push({ name: 'action', value: 'send_contact_us_email' });
            formData.push({ name: 'page_url', value: window.location.href });

            $.ajax({
                url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
                type: 'POST',
                dataType: 'json',
                data: $.param(formData),
                beforeSend: function(){
                    $btn.prop('disabled', true).text('Sending...');
                },
                success: function(res){
                    if (res.success) {
                        $('#formSuccess').text(res.data.msg).show();
                        $form[0].reset();
                    } else {
                        alert(res.data && res.data.msg ? res.data.msg : 'Submission failed.');
                    }
                },
                error: function(){
                    alert('Network or server error, please try again later.');
                },
                complete: function(){
                    $btn.prop('disabled', false).text('Submit');
                }
            });
        });
    });
</script>
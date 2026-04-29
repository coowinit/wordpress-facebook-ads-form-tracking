<!--Contact Section-->
<section class="contact-section">
    <div class="auto-container">
        <div class="info-container mb-3">

            <!-- 1. 表单 -->
            <form id="contactus" class="mb-4">
                <!-- 先在表单里加 nonce -->
                <?php wp_nonce_field('contact_us_nonce', 'contact_us_nonce'); ?>
                <h3 class="mb-2">Find Your Nearest Dealer</h3>
                <p class="text-muted mb-4">
                    Please fill in the following information. After submitting the form, you will be able to view details of the nearest authorized dealer.
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

            <!-- 用户操作按钮和经销商信息，初始隐藏 -->
            <div id="dealerSection" style="display:none;">
                <div class="text-center mb-4">
                    <button id="getLocationBtn" class="btn btn-secondary">
                        Find the nearest dealer
                    </button>
                    <div id="userPosition" class="small text-muted mb-4 mt-2">Your location: Not found</div>
                    <div id="dealerResult"></div>
                </div>
            </div>

            <?php 
                $args =[ 'post_type'=>'distributors','posts_per_page'=>50,'orderby'=>'date','order'=>'ASC' ];
                $query = new WP_Query($args);
                $dealers_data = [];
                if($query->have_posts()):
                    while($query->have_posts()): $query->the_post();
                        $dealers_data[] = [
                            'title'=>get_the_title(),
                            'contact'=>get_post_meta(get_the_ID(),'dist_contact',true),
                            'company'=>get_post_meta(get_the_ID(),'dist_incor',true),
                            'website'=>get_post_meta(get_the_ID(),'dist_website',true),
                            'phone'=>get_post_meta(get_the_ID(),'dist_phone',true),
                            'cellphone'=>get_post_meta(get_the_ID(),'dist_cellphone',true),
                            'email'=>get_post_meta(get_the_ID(),'dist_email',true),
                            'address'=>get_post_meta(get_the_ID(),'dist_address',true),
                            'notes'=>get_post_meta(get_the_ID(),'dist_notes',true),
                            'maps'=>get_post_meta(get_the_ID(),'dist_maps',true),
                            'lat'=>get_post_meta(get_the_ID(),'dist_lat',true),
                            'lng'=>get_post_meta(get_the_ID(),'dist_lng',true),
                        ];
                    endwhile;
                endif;
                wp_reset_postdata();
            ?>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dealers = <?php echo wp_json_encode($dealers_data); ?> || [];
            const MAX_DISTANCE_KM = 500;  // 公里数
            let userLat = null, userLng = null;

            const $ = s=>document.querySelector(s);
            const dealerSection = $('#dealerSection');
            const form = $('#contactus');
            const formSuccess = $('#formSuccess');
            const resultBox = $('#dealerResult');
            const userPosBox = $('#userPosition');

            function updateUserPositionUI(){
                if(!userPosBox) return;
                if(userLat!=null && userLng!=null){
                    userPosBox.textContent=`Your location:${userLat.toFixed(6)}, ${userLng.toFixed(6)}`;
                }else userPosBox.textContent='Your location: Not found';
            }

            function getDistance(lat1, lon1, lat2, lon2){
                const rad=x=>x*Math.PI/180;
                const R=6371;
                const dLat=rad(lat2-lat1);
                const dLon=rad(lon2-lon1);
                const a=Math.sin(dLat/2)**2 + Math.cos(rad(lat1))*Math.cos(rad(lat2))*Math.sin(dLon/2)**2;
                return R*2*Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            }

            function findNearestDealer(uLat,uLng){
                let nearest=null,minDist=Infinity;
                dealers.forEach(d=>{
                    if(!d.lat||!d.lng) return;
                    const dist=getDistance(uLat,uLng,parseFloat(d.lat),parseFloat(d.lng));
                    if(dist<minDist){ minDist=dist; nearest={...d,distance:dist}; }
                });
                return nearest&&minDist<=MAX_DISTANCE_KM?nearest:null;
            }

            function renderNotFound(msg){
                if(!resultBox) return;
                resultBox.innerHTML=`<div class="alert alert-warning">${msg||`No dealers were found within ${MAX_DISTANCE_KM} km.`}</div>`;
            }

            function renderDealer(dealer){
                if(!dealer){ renderNotFound(); return; }
                resultBox.innerHTML=`<div class="row align-items-center text-maps-box">
                    <div class="info-block col-md-6">
                        <div class="contact-box">
                            <div class="cnt box02 maps">
                                <h3>${dealer.title||''}</h3>
                                <ul>
                                    ${dealer.contact?`<li><span class="icon fa fa-user-alt"></span>${dealer.contact}</li>`:''}
                                    ${dealer.company?`<li><span class="icon fa fa-building"></span>${dealer.company}</li>`:''}
                                    ${dealer.website?`<li><span class="icon fa fa-globe"></span><a href="https://${dealer.website}" target="_blank" rel="nofollow noopener">${dealer.website}</a></li>`:''}
                                    ${dealer.phone?`<li><span class="icon fa fa-phone-alt"></span><a href="tel:${dealer.phone}">${dealer.phone}</a></li>`:''}
                                    ${dealer.cellphone?`<li><span class="icon fa fa-mobile-alt"></span><a href="tel:${dealer.cellphone}">${dealer.cellphone}</a></li>`:''}
                                    ${dealer.email?`<li><span class="icon fa fa-envelope"></span><a href="mailto:${dealer.email}">${dealer.email}</a></li>`:''}
                                    ${dealer.address?`<li><span class="icon fa fa-map-marker-alt"></span>${dealer.address}</li>`:''}
                                </ul>
                                ${dealer.notes?`<p>${dealer.notes}</p>`:''}
                                <p style="color:red;">The nearest dealer is approximately ${dealer.distance.toFixed(1)} km away</p>
                            </div>
                        </div>
                    </div>
                    <div class="google-map col-md-6">
                        <div class="contact-box">
                            <div class="cnt box02 maps">
                                ${dealer.maps?`<iframe src="${dealer.maps}" width="100%" height="260" style="border:0;" allowfullscreen></iframe>`:'Map unavailable'}
                            </div>
                        </div>
                    </div>
                </div>`;
            }

            function getLocationAndRender(){
                if(!navigator.geolocation){ alert('The browser does not support positioning'); return; }
                resultBox.innerHTML=`<div class="alert alert-info">Getting current location...</div>`;
                navigator.geolocation.getCurrentPosition(pos=>{
                    userLat=pos.coords.latitude;
                    userLng=pos.coords.longitude;
                    updateUserPositionUI();
                    const dealer=findNearestDealer(userLat,userLng);
                    renderDealer(dealer);
                }, err=>{
                    renderNotFound('Unable to obtain current location');
                }, {enableHighAccuracy:true, timeout:10000, maximumAge:0});
            }

            // 表单 Ajax 提交
            form.addEventListener('submit', function(e){
                e.preventDefault();
                const formData=new FormData(form);
                formData.append('action','send_contact_us_email');

                // 获取当前页面 URL
                formData.append('page_url', window.location.href);

                fetch("<?php echo admin_url('admin-ajax.php'); ?>",{
                    method:'POST',
                    body:formData
                })
                .then(res=>res.json())
                .then(data=>{
                    if(data.success){
                        form.style.display='none';
                        formSuccess.style.display='block';
                        dealerSection.style.display='block';
                    }else{
                        alert(data.data && data.data.msg ? data.data.msg : 'Failed to send email, please try again');
                    }
                })
                .catch(()=>alert('Request failed, please try again'));
            });

            // 按钮点击
            $('#getLocationBtn').addEventListener('click', getLocationAndRender);

        });
        </script>


        </div>
    </div>
</section>
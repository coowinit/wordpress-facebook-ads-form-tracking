
<section class="product-details">
  <div class="auto-container">
    <div class="content-container">
      <div class="row clearfix"> 
        <div class="content-side col-lg-8 col-md-12 col-sm-12">
          <!--productcarouse-->
          <div class="productcarouse fadeInUp animated">
            <div class="carouselOne owl-carousel owl-theme">
              <?php 
                $pic01 = get_post_meta( get_the_ID(), 'product_pic01', true ); 
                $pic02 = get_post_meta( get_the_ID(), 'product_pic02', true );
                $pic03 = get_post_meta( get_the_ID(), 'product_pic03', true ); 
                $pic04 = get_post_meta( get_the_ID(), 'product_pic04', true );
                $pic05 = get_post_meta( get_the_ID(), 'product_pic05', true );
                $pic06 = get_post_meta( get_the_ID(), 'product_pic06', true );
                $params = get_post_meta(get_the_ID(), 'product_param',true); 
                $vr360 = get_post_meta(get_the_ID(), 'product_vrvideo',true); 
                $qrcode = get_post_meta(get_the_ID(), 'product_qrcode',true); 
                $pselect = get_post_meta(get_the_ID(), 'product_select',true); 
                $newclass = ( $pselect == 'option-two' ) ? 'show' : 'hide';
              ?>
              <?php 
                if( $pic01 ){ echo '<div class="item"><img src="'.$pic01.'" alt=""></div>'; }
                if( $pic02 ){ echo '<div class="item"><img src="'.$pic02.'" alt=""></div>'; } 
                if( $pic03 ){ echo '<div class="item"><img src="'.$pic03.'" alt=""></div>'; } 
                if( $pic04 ){ echo '<div class="item"><img src="'.$pic04.'" alt=""></div>'; } 
                if( $pic05 ){ echo '<div class="item"><img src="'.$pic05.'" alt=""></div>'; } 
                if( $pic06 ){ echo '<div class="item"><img src="'.$pic06.'" alt=""></div>'; } 
              ?>
            </div>
            <div class="carouselTwo owl-carousel owl-theme" data-slides-per-page="4">
              <?php 
                if( $pic01 ){ echo '<div class="item"><img src="'.$pic01.'" alt=""></div>'; }
                if( $pic02 ){ echo '<div class="item"><img src="'.$pic02.'" alt=""></div>'; } 
                if( $pic03 ){ echo '<div class="item"><img src="'.$pic03.'" alt=""></div>'; } 
                if( $pic04 ){ echo '<div class="item"><img src="'.$pic04.'" alt=""></div>'; } 
                if( $pic05 ){ echo '<div class="item"><img src="'.$pic05.'" alt=""></div>'; } 
                if( $pic06 ){ echo '<div class="item"><img src="'.$pic06.'" alt=""></div>'; } 
              ?>
            </div>
            <span class="icon-bal29 <?php echo $newclass; ?>"></span>
          </div>
          <!--End productcarouse-->

          <div class="info-title fadeInUp animated">
            <div class="left-info">
              <h3><?php the_title(); ?></h3>
              <p><?php echo get_the_excerpt(); ?></p>
            </div>
          </div>
          <!--End info-title-->

          <?php 
            $term_obj = get_the_terms( get_the_ID(), 'product_cat' ); 
            $term_id = $term_obj[0]->term_id;
          ?>
          <?php if( in_array($term_id, array(120,121,122,123)) ): ?>
            <div class="calculate fadeInUp animated" style="display:none">
              <div class="row">
                <div class="content-side col-lg-12 col-md-12 col-sm-12">
                  <div class="mb-4">
                      <h2><i><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none"><g clip-path="url(#B)"><mask id="A" maskUnits="userSpaceOnUse" x="0" y="0" width="28" height="28"><path d="M28 0H0V28H28V0Z" fill="#fff"/></mask><g mask="url(#A)"><path d="M10.574 0H1.865C.834 0 0 .834 0 1.865v8.706c0 1.031.834 1.865 1.865 1.865h8.706c1.031 0 1.865-.834 1.865-1.865V1.865A1.86 1.86 0 0 0 10.574 0zm-.468 6.997H6.997v3.109H5.441V6.997H2.332V5.441h3.109V2.332h1.556v3.109h3.109v1.556zM26.122 0h-8.709c-1.031 0-1.865.834-1.865 1.865v8.706c0 1.031.834 1.865 1.865 1.865h8.706c1.031 0 1.865-.834 1.865-1.865V1.865A1.86 1.86 0 0 0 26.122 0zm-.468 6.997H17.88V5.441h7.774v1.556zm-15.08 8.55H1.865C.834 15.548 0 16.384 0 17.413v8.706c0 1.031.834 1.865 1.865 1.865h8.706c1.031 0 1.865-.834 1.865-1.865v-8.706c.003-1.028-.834-1.865-1.862-1.865zm-1.055 8.419l-1.099 1.099-2.198-2.198-2.201 2.198-1.099-1.099 2.198-2.198L2.92 19.57l1.099-1.099 2.198 2.198 2.198-2.198 1.099 1.099-2.198 2.196 2.201 2.201zm16.603-8.419h-8.709c-1.031 0-1.865.834-1.865 1.865v8.706c0 1.031.834 1.865 1.865 1.865h8.706c1.031 0 1.865-.834 1.865-1.865v-8.706c.003-1.028-.834-1.865-1.862-1.865zm-1.244 8.55h-6.221v-1.556h6.218v1.556h.003zm0-3.109h-6.221v-1.556h6.218v1.556h.003z" fill="#651e7c"/></g></g><defs><clipPath id="B"><path fill="#fff" d="M0 0h28v28H0z"/></clipPath></defs></svg></i> <span>Calculate Your Project</span></h2>
                  </div>
                  <h3>Enter the dimensions of the project:</h3>
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text">length(m):</span>
                      </div>
                      <input type="text" class="form-control" id="length" name="length">
                  </div>
                  <div class="input-group mb-4">
                      <div class="input-group-prepend">
                          <span class="input-group-text">Width(m):</span>
                      </div>
                      <input type="text" class="form-control" id="width" name="width">
                  </div>
                  <h3>Or enter the area directly:</h3>
                  <div class="input-group mb-4">
                      <div class="input-group-prepend">
                          <span class="input-group-text">Area(sqm):</span>
                      </div>
                      <input type="text" class="form-control" id="mianji" name="mianji">
                  </div>
                  <h3>Products & accessories you need:</h3>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text my">Product(pcs):</span>
                      </div>
                      <input type="number" class="form-control" id="cps_664" step="1" min="0" max="5000" name="cps" value="0" title="Qty" inputmode="numeric">
                  </div>
                  <div class="mb-3"><small id="emailHelp" class="form-text text-muted">5.4m/pc</small></div>

                  <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text my">Accessories Bucket(sets):</span>
                      </div>
                      <span id="pjt" class="form-control" data-pjt=""></span>
                  </div>
                  <div class="mb-3"><small id="emailHelp" class="form-text text-muted">
                    <b>1 bucket contains:</b> 
                    <?php
                      if ($curr_id !== null) {
                          if (in_array($curr_id, [120, 121])) {
                              echo '300pcs SS hidden deck fasteners; 16pcs starter clip; 30pcs SS screw 4*25mm; 50pcs SS color screw 4*35mm. Decking for 12.5 to 16m² per pail.';
                          } elseif (in_array($curr_id, [122, 123])) {
                              echo '500PCS expansion screw 6x80mm #304 SS. 1500PCS Self-Drilling Screw 4*25# 410 SS. 100PCS self drilling color screw(s.s.) 4*35mm #410 SS. Cladding for 50m² per pail.';
                          }
                      }
                    ?>
                  </small>
                  </div>

                  <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text my">Fascia Board / L corner(m):</span>
                      </div>
                      <span id="hujiao" class="form-control" data-hujiao=""></span>
                  </div>
                  <div class="mb-3"><small id="emailHelp" class="form-text text-muted">Subject to the actual situation, use fascia board for decking and L corner for cladding.</small></div>

                  <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text my">Joist / Aluminum Joist(m):</span>
                      </div>
                      <span id="longgu" class="form-control" data-longgu=""></span>
                  </div>
                  <div class="mb-3"><small id="emailHelp" class="form-text text-muted">Decking uses joist, cladding uses aluminum joist.</small></div>

                  <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text my">Expansion Screw(pcs):</span>
                      </div>
                      <span id="luosi" class="form-control" data-luosi=""></span>
                  </div>
                  <div class="mb-4"><small id="emailHelp" class="form-text text-muted">Please refer to the actual situation for the quantity of all accessories.</small></div>
                  
                  <div class="btn-my">
                      <button type="button" class="btn btn-dark">Calculate</button>
                      <a href="#get-quote-now" id="focus-link" class="btn btn-dark" style="background-color:#651e7c;border-color:#651e7c;">Get Quote Now</a>
                  </div>
                </div>
              </div>
            </div>
          <!--/.calculate-->
          <?php endif; ?>

          <div class="text-block wow fadeInUp">
            <div class="wincontent">
              <?php the_content(); ?>
              <?php echo do_shortcode( '[elementor-template id="product_template"]' ); ?>
            </div>
          </div>
          <!--End text-block-->

        </div>
        <!--End col-lg-8-->
        
        <div class="widgets-side col-lg-4 col-md-6 col-sm-12">
          <div class="widgets-content" id="get-quote-now"> 

            <div class="tour-widget single-booking-widget wow fadeInUp" data-wow-delay="0.5s" data-wow-duration="1.5s">
              <div class="widget-inner">
                <div class="upper-info clearfix">
                  <div class="free-sample-info">
                    <img src="/wp-content/uploads/2023/12/Get-a-Free-Sample.jpg" />
                  </div>
                </div>
                <div class="default-form main-booking-form">
                  <form action="https://www.coowin.top/updata.php" enctype="multipart/form-data" method="post">
                  <input type="hidden" name="from_company" value="EVODEK">
                  <input type="hidden" name="products" value="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
                  <h5>Get Quote and Free Sample!</h5>
                  <div class="form-group">
                    <div class="field-inner">
                    <input name="name" type="text" placeholder="Your name *" id="target-input" required="" oninvalid="setCustomValidity('Enter your name');" oninput="setCustomValidity('');">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="field-inner">
                    <input name="phone" type="text" placeholder="Your phone">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="field-inner">
                    <input name="email" type="email" placeholder="Your email *" required="" oninvalid="setCustomValidity('Enter your email');" oninput="setCustomValidity('');">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="field-inner">
                    <input name="title" type="text" placeholder="Your subject" required="" oninvalid="setCustomValidity('Enter your subject');" oninput="setCustomValidity('');">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="field-inner">
                    <textarea name="content" style="height:120px;line-height:24px" placeholder="Your needs *" required="" oninvalid="setCustomValidity('Enter your requirements');" oninput="setCustomValidity('');"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="theme-btn"><span class="btn-title">Send Message</span></button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <!--End Form-->

            <div class="tour-widget advisor-widget wow fadeInUp" data-wow-delay="0.5s" data-wow-duration="1.5s">
              <div class="widget-inner"> 
                <div class="advisor-block">
                  <div class="inner-box">
                    <div class="image-box"> <a href="#"><img src="/wp-content/uploads/2023/12/pkefu.jpg" alt="composite decking" /></a> </div>
                    <div class="lower-box clearfix">
                      <div class="lower-content">
                        <h4><a>Ms.Elaine Lee</a></h4>
                        <div class="info"><span class="icon flaticon-telephone"></span>+61 283111111</div>
                        <div class="info"><span class="icon flaticon-email"></span>market08@evodekco.com</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--End Contact-->

            <div class="tour-widget single-booking-widge" style="display:none">
              <div class="widget-inner">
                <div class="default-form main-booking-form pdfslist">
                  <h5>Download</h5>
                    <?php 	
                      // 后台填写的字符串，比如 8,10,15 等
                      $pdf_ids_string = get_post_meta( get_the_ID(), 'pdf_ids', true ); 
                      // 将逗号分隔的字符串转换为数组
                      $pdf_ids_array = explode(',', $pdf_ids_string);
                      // 创建查询参数
                      $args = array(
                        'post_type' => 'downloads',
                        'post__in' => $pdf_ids_array, // 使用帖子 ID 数组作为查询条件
                        'orderby' => 'post__in',
                        'tax_query' => array(
                            'relation' => 'OR',
                            array(
                                'taxonomy' => 'download_cat',
                                'field' => 'slug',
                                'terms' => 'download',
                            ),
                            array(
                                'taxonomy' => 'download_cat',
                                'field' => 'slug',
                                'terms' => 'productpdf',
                            ),
                        )
                      );
                      $pdfquery = new WP_Query( $args );
                      //print_r($pdfquery);
                    ?>
                    <?php if ($pdfquery->have_posts()): ?>
                    <ul>
                      <?php while ($pdfquery->have_posts()): $pdfquery->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>" target="_blank"><i class="fa fa-file-pdf my"></i> <?php the_title(); ?></a></li>
                      <?php endwhile; ?>
                    </ul>
                    <?php wp_reset_postdata(); ?>
                    <?php else: ?>
                    <p>No related files found.</p>
                    <?php endif; ?>

                </div>
              </div>
            </div>
            <!--End Download-->

            <div class="tour-widget single-booking-widget wow fadeInUp" data-wow-delay="0.5s" data-wow-duration="1.5s">
              <div class="widget-inner">
                <div class="default-form main-booking-form">
                  <h5>Related Products</h5>
                  <?php
                    $current_product_id = get_the_ID();
                    $product_categories = get_the_terms( $current_product_id, 'product_cat' );
                    // 如果有相关的分类
                    if ( $product_categories ) {
                        // 从分类中获取第一个分类的ID
                        $category_id = $product_categories[0]->term_id;
                        // 查询与当前分类相关的其他产品
                        $args = array(
                            'post_type' => 'products', // 假设产品使用了名为“products”的自定义文章类型
                            'posts_per_page' => 3,    // 显示3个相关产品
                            'post__not_in' => array( $current_product_id ), // 排除当前产品
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'id',
                                    'terms' => $category_id, // 只显示与当前分类相关的产品
                                ),
                            ),
                        );
                        $related_products = new WP_Query( $args );
                    }
                  ?>
                  <?php if ( $related_products->have_posts() ): ?>
                  <div class="swiper mySwiper">
                      <div class="swiper-wrapper">
                        <?php while ( $related_products->have_posts() ): $related_products->the_post(); ?>
                        <?php $firstimg = get_post_meta( get_the_ID(), 'product_pic01', true ); ?> 
                          <div class="swiper-slide">
                            <div class="right-related-product">
                                <a href="<?php the_permalink(); ?>"><img src="<?php echo $firstimg; ?>" alt="<?php the_title_attribute(); ?>" /></a>
                                <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                            </div>
                          </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                      </div>
                      <div class="swiper-pagination"></div>
                  </div>
                  <?php else: ?>
                    <p>No related products.</p>
                  <?php endif; ?>
                  
                  <script nowprocket>
                    var swiper = new Swiper(".mySwiper", {
                      loop: true,
                      pagination: {
                        el: '.swiper-pagination',
                        clickable: true, // 允许点击切换
                      },
                      //启动自动切换
                      autoplay: {
                        delay: 3000, // 设置自动播放的间隔时间
                        disableOnInteraction: false, //用户操作swiper之后，是否禁止autoplay。默认为true：停止。
                      },
                    });
                  </script>
                  
                </div>
              </div>
            </div>
            <!--End Related Products-->
            
          </div>
        </div>
        <!--End col-lg-4-->
        
      </div>
    </div>
  </div>
</section>

<script nowprocket src="<?php bloginfo('template_directory'); ?>/js/productcarouse.js"></script>
<!-- 产品加配件的智能计算 -->
<?php 
  $ratio01 = get_post_meta(get_the_ID(), 'area_accessory',true); 
  $ratio02 = get_post_meta(get_the_ID(), 'area_product',true); 
?>
<script>
    // 系数定义
    const MIANJI_TO_PJTS = <?php if(empty($ratio01)) { echo "1/14"; } else { echo $ratio01; } ?>;  // 面积与配件桶的系数-（每平方米适用配件桶数）
    const MIANJI_TO_CPS = <?php if(empty($ratio02)) { echo "1.30"; } else { echo $ratio02; } ?>;  // 面积与产品的系数-（每平方米适用产品数）
    // 后来新增的系数
    const MIANJI_TO_HUJIAO = 0.5;  // 面积与护角的系数-（每平方米适用护角数）
    const MIANJI_TO_LONGGU = 3.5;  // 面积与龙骨的系数-（每平方米适用龙骨数）
    const MIANJI_TO_LUOSI = 12;  // 面积与膨胀螺丝的系数-（每平方米适用膨胀螺丝数）

    // 计算配件桶数量（并向上取整）
    function calculatePeijian(mianji) {
        return Math.ceil(mianji * MIANJI_TO_PJTS);
    }
    // 计算护角数量（并向上取整）
    function calculateHujiao(mianji) {
        return Math.ceil(mianji * MIANJI_TO_HUJIAO);
    }
    // 计算龙骨数量（并向上取整）
    function calculateLonggu(mianji) {
        return Math.ceil(mianji * MIANJI_TO_LONGGU);
    }
    // 计算螺丝数量（并向上取整）
    function calculateLuosi(mianji) {
        return Math.ceil(mianji * MIANJI_TO_LUOSI);
    }

    // 更新页面上的数值
    function updateValues(mianjiNum, chanpinNum) {
        // 计算配件桶数量
        const pjt = calculatePeijian(mianjiNum);
        // 计算护角数量
        const hujiao = calculateHujiao(mianjiNum);
        // 计算龙骨数量
        const longgu = calculateLonggu(mianjiNum);
        // 计算螺丝数量
        const luosi = calculateLuosi(mianjiNum);

        // 处理非法值情况
        if (isNaN(mianjiNum) || !isFinite(mianjiNum) || mianjiNum < 0) {
            mianjiNum = 0;
        }
        if (isNaN(chanpinNum) || !isFinite(chanpinNum) || chanpinNum < 0) {
            chanpinNum = 0;
        }

        // 更新面积输入框的值
        document.getElementById('mianji').value = mianjiNum.toFixed(2);
        // 更新配件桶数量显示和数据属性
        document.getElementById('pjt').textContent = pjt;
        document.getElementById('pjt').setAttribute('data-pjt', pjt);
        // 更新护角数量显示和数据属性
        document.getElementById('hujiao').textContent = hujiao;
        document.getElementById('hujiao').setAttribute('data-hujiao', hujiao);
        // 更新龙骨数量显示和数据属性
        document.getElementById('longgu').textContent = longgu;
        document.getElementById('longgu').setAttribute('data-longgu', longgu);
        // 更新螺丝数量显示和数据属性
        document.getElementById('luosi').textContent = luosi;
        document.getElementById('luosi').setAttribute('data-luosi', luosi);

        // 更新产品数量输入框的值
        document.querySelector('input[name="cps"]').value = chanpinNum.toFixed(0);
    }

    // 当长度或宽度输入框的值发生变化时，更新面积
    function updateMianji() {
        // 获取长度和宽度输入框中的值，并将其转换为浮点数类型
        const length = parseFloat(document.getElementById('length').value);
        const width = parseFloat(document.getElementById('width').value);
        let mianjiNum = length * width;
        // 检查计算得到的面积是否是非法值（NaN）或小于。如果是，则将面积设置为0
        if (isNaN(mianjiNum) || mianjiNum < 0) {
            mianjiNum = 0;
        }
        // 根据计算得到的面积，使用系数`MIANJI_TO_CPS`计算产品数量（cps）
        const chanpinNum = mianjiNum * MIANJI_TO_CPS;
        updateValues(mianjiNum, chanpinNum);
    }

    // 当面积输入框的值发生变化时，更新页面上的数值并清空长度和宽度输入框
    document.getElementById('mianji').addEventListener('change', function() {
        let mianjiNum = parseFloat(this.value);
        if (isNaN(mianjiNum) || mianjiNum < 0) {
            mianjiNum = 0;
        }
        const chanpinNum = mianjiNum * MIANJI_TO_CPS;
        updateValues(mianjiNum, chanpinNum);

        // 清空长度和宽度输入框的值
        document.getElementById('length').value = '';
        document.getElementById('width').value = '';
    });

    // 当产品数量输入框的值发生变化时，更新页面上的数值
    document.querySelector('input[name="cps"]').addEventListener('change', function() {
        let chanpinNum = parseFloat(this.value);
        if (isNaN(chanpinNum) || chanpinNum < 0) {
            chanpinNum = 0;
        }
        const mianjiNum = chanpinNum / MIANJI_TO_CPS;
        updateValues(mianjiNum, chanpinNum);

        // 清空长度和宽度输入框的值
        document.getElementById('length').value = '';
        document.getElementById('width').value = '';
    });

    // 当长度或宽度输入框的值发生变化时，更新面积
    document.getElementById('length').addEventListener('change', updateMianji);
    document.getElementById('width').addEventListener('change', updateMianji);

    // 默认值
    const defaultMianji = 0;
    const defaultCps = 0;
    updateValues(defaultMianji, defaultCps);
</script>

<!-- 点击链接让目标输入框获得焦点 -->
<script>
  // 获取链接和输入框元素
  const focusLink = document.getElementById('focus-link');
  const targetInput = document.getElementById('target-input');
  // 为链接添加点击事件监听器
  focusLink.addEventListener('click', (event) => {
    event.preventDefault(); // 防止链接的默认行为
    targetInput.focus(); // 让目标输入框获得焦点
  });
</script>
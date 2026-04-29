<?php

// 公用 SMTP 设置（一次配置，其他页面复用）
add_action('phpmailer_init', 'custom_phpmailer_smtp_setup');
function custom_phpmailer_smtp_setup($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'smtp.163.com';
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = 465;
    $phpmailer->Username   = 'yangwenguan@163.com';
    $phpmailer->Password   = '授权码';  // 授权码
    $phpmailer->SMTPSecure = 'ssl';
    $phpmailer->CharSet    = 'UTF-8';
}

// 统一设置所有 wp_mail() 发送邮件时的发件邮箱地址
add_filter( 'wp_mail_from', function( $from ) { return 'yangwenguan@163.com'; } );
// 统一设置所有 wp_mail() 发送邮件时的发件人名称：一般写品牌名或者域名
add_filter( 'wp_mail_from_name', function( $name ) { return 'EVODEK'; } );

// === EVODEK 通用地区配置开始 ===
function evodek_get_default_email() {
    return 'info@evodekco.com';
}

function evodek_get_region_email_map() {
    $default_email = evodek_get_default_email();

    return [
        'Queensland'        => 'jared@addlifetimbers.com.au',
        'New South Wales'   => $default_email,
        'Victoria'          => $default_email,
        'South Australia'   => $default_email,
        'Western Australia' => $default_email,
    ];
}

function evodek_get_recipient_by_state($state) {
    $region_emails = evodek_get_region_email_map();
    return $region_emails[$state] ?? evodek_get_default_email();
}

function evodek_get_cc_by_state($state) {
    if ($state === 'Queensland') {
        return evodek_get_default_email();
    }
    return '';
}

function evodek_get_state_options() {
    return array_keys(evodek_get_region_email_map());
}

function evodek_render_state_options($selected = '') {
    $html = '<option value="">Select Australian State you are in*</option>';

    foreach (evodek_get_state_options() as $state) {
        $html .= sprintf(
            '<option value="%1$s" %2$s>%1$s</option>',
            esc_attr($state),
            selected($selected, $state, false)
        );
    }

    return $html;
}
// === EVODEK 通用地区配置结束 ===

// === Queensland 地区邮件头部/底部包装-开始 ===
// 获取邮件中使用的 Logo 图片地址
function evodek_get_email_logo_url() {
    return get_theme_file_uri('images/logo-email.png');
}

// 为 Queensland 地区代理商邮件追加头部和底部说明
// 说明：
// 1. 仅 Queensland 地区生效；
// 2. 其他地区邮件内容保持不变；
// 3. 仍然使用 table 结构，提升邮箱客户端兼容性；
// 4. 样式尽量简化，只保留必要的上下间距，便于后期维护。
function evodek_wrap_qld_email($content, $state) {
    if (trim((string) $state) !== 'Queensland') {
        return $content;
    }

    $logo_url      = esc_url(evodek_get_email_logo_url());
    $support_email = 'info@evodek.com.au';
    $phone         = '02 8311 1111';
    $website_url   = 'https://www.evodek.com.au';
    $website_text  = 'www.evodek.com.au';

    // 邮件头部：Logo + 说明文字
    ob_start();
    ?>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td style="padding:20px 0 12px 0; font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:1.8; color:#222;">
                <p style="margin:0 0 16px 0;">
                    <img src="<?php echo $logo_url; ?>" alt="EVODEK" style="max-width:220px; height:auto; border:0; display:inline-block;">
                </p>
                <p style="margin:0 0 12px 0;font-weight:bold;">Legendary TPD Team,</p>
                <p style="margin:0;">
                    New instant lead from the EVODEK website for your follow-up. <br />
					<strong>Customer NOT contacted by EVODEK.</strong> <br />
                    Full ownership assigned per our partnership, with full sample and technical support to be provided by your team. <br />
                </p>
				<p style="margin-top:20px;">*************************************************************</p>
            </td>
        </tr>
    </table>
    <?php
    $header_html = ob_get_clean();

    // 邮件底部：支持信息 + 联系方式
    ob_start();
    ?>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td style="padding:12px 0 20px 0;">
				<p style="margin-top:20px 0 15px;">*************************************************************</p>
                <p style="margin:0;">
                    For support, contact us at
                    <a href="mailto:<?php echo esc_attr($support_email); ?>" style="text-decoration:underline;">
                        <?php echo esc_html($support_email); ?>
                    </a>
                </p>
                <p>
					Regards, <br />
					The EVODEK Team, <br />
					Phone: <?php echo esc_html($phone); ?> <br />
                    <a href="<?php echo esc_url($website_url); ?>" target="_blank" style="text-decoration:underline;">
                        <?php echo esc_html($website_text); ?>
                    </a>
                </p>
            </td>
        </tr>
    </table>
    <?php
    $footer_html = ob_get_clean();

    return $header_html . $content . $footer_html;
}
// === Queensland 地区邮件头部/底部包装-结束 ===

// 购物车功能-开始
// 1. 启用PHP Session（无需登录）
add_action('init', 'start_session', 1);
function start_session() {
    if (!session_id()) {
        session_start();
    }
    // 初始化购物车
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
}

// 2. 注册AJAX脚本和处理函数
add_action('wp_enqueue_scripts', 'enqueue_cart_scripts');
function enqueue_cart_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-cart', get_template_directory_uri() . '/js/cart.js', array('jquery'), '1.0', true);
    wp_localize_script('custom-cart', 'cartAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('cart_nonce')
    ));
}

// 3. AJAX处理：加入购物车
add_action('wp_ajax_add_to_cart', 'ajax_add_to_cart');
add_action('wp_ajax_nopriv_add_to_cart', 'ajax_add_to_cart'); // 支持未登录用户
function ajax_add_to_cart() {
    check_ajax_referer('cart_nonce', 'nonce');

    $product_id = sanitize_text_field($_POST['product_id']);
    $product_name = sanitize_text_field($_POST['product_name']);

    // 强化处理逻辑，防止空字符串、0、负数
    $quantity_raw = $_POST['quantity'] ?? 1;
    $quantity = (is_numeric($quantity_raw) && intval($quantity_raw) > 0) ? intval($quantity_raw) : 1;

	// 调试日志--会写入错误日志中
    // error_log('AJAX Add To Cart Debug ---');
    // error_log('product_id: ' . $product_id);
	// error_log('product_name (from $_POST): ' . $product_name);  // 产品名称
    // error_log('post_status: ' . get_post_status($product_id));  // 发布状态
    // error_log('post_type: ' . get_post_type($product_id));  // 产品内容类型

    // 验证产品是否存在
    if ($product_id && get_post_status($product_id) === 'publish') {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = array(
                'product_name' => $product_name,
                'quantity' => $quantity
            );
        }

        wp_send_json_success(array(
            'message' => 'Already added to cart!',
            'debug_cart' => $_SESSION['cart']
        ));
    } else {
        wp_send_json_error(array(
            'message' => 'Invalid product, please try again.'
        ));
    }
}

// 4. AJAX处理：更新购物车
add_action('wp_ajax_update_cart', 'ajax_update_cart');
add_action('wp_ajax_nopriv_update_cart', 'ajax_update_cart'); // 支持未登录用户
function ajax_update_cart() {
    check_ajax_referer('cart_nonce', 'nonce');

    $cart = $_POST['cart'];

	// 查看是否 JS 有正确传数据过来
	// error_log('更新购物车数据: ' . print_r($_POST['cart'], true));

    foreach ($cart as $product_id => $data) {
        $product_id = sanitize_text_field($product_id);
        $quantity = intval($data['quantity']);

        if ($quantity > 0) {
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    wp_send_json_success(array(
        'message' => 'Shopping cart updated!',
        'cart_count' => get_cart_count()
    ));
	wp_die(); // 这一行是必须的
}

// 5. 处理表单提交并发送邮件
add_action('wp', 'handle_cart_submission');
function handle_cart_submission() {
    if (!isset($_POST['submit_cart'])) {
        return;
    }

    if (!isset($_POST['cart_submit_nonce']) || !wp_verify_nonce($_POST['cart_submit_nonce'], 'cart_submit_nonce')) {
        set_transient('cart_notice', 'Security verification failed, please refresh the page and try again.', 30);
        return;
    }

    $name     = sanitize_text_field($_POST['customer_name'] ?? '');
    $phone    = sanitize_text_field($_POST['customer_phone'] ?? '');
    $email    = sanitize_email($_POST['customer_email'] ?? '');
    $state    = sanitize_text_field($_POST['state'] ?? '');
    $message  = sanitize_textarea_field($_POST['customer_message'] ?? '');
    $page_url = esc_url_raw(home_url(add_query_arg(array(), $_SERVER['REQUEST_URI'] ?? '/')));

    if (!$name || !$phone || !$email || !$state) {
        set_transient('cart_notice', 'Please complete all required fields before submitting the cart.', 30);
        return;
    }

    if (!is_email($email)) {
        set_transient('cart_notice', 'Please enter a valid email address.', 30);
        return;
    }

    $cart = $_SESSION['cart'] ?? array();
    if (empty($cart)) {
        set_transient('cart_notice', 'The shopping cart is empty and cannot be submitted.', 30);
        return;
    }

    $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
    $user_agent = sanitize_text_field($_SERVER['HTTP_USER_AGENT'] ?? '');

    $cart_html = '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse:collapse;width:100%;">';
    $cart_html .= '<thead><tr><th style="background:#f5f5f5;">Product Name</th><th style="background:#f5f5f5;">Quantity</th></tr></thead><tbody>';

    foreach ($cart as $item) {
        $product_name = esc_html($item['product_name']);
        $quantity     = intval($item['quantity']);
        $cart_html .= "<tr><td>{$product_name}</td><td>{$quantity}</td></tr>";
    }

    $cart_html .= '</tbody></table>';

    $to      = evodek_get_recipient_by_state($state);
	$cc = evodek_get_cc_by_state($state);

    $subject = 'evodek.com.au Cart Submission - ' . $state;

    $email_body = ''
        . '<h2>New Cart Submission</h2>'
        . '<p><strong>Name:</strong> ' . esc_html($name) . '</p>'
        . '<p><strong>Phone:</strong> ' . esc_html($phone) . '</p>'
        . '<p><strong>Email:</strong> ' . esc_html($email) . '</p>'
        . '<p><strong>State:</strong> ' . esc_html($state) . '</p>'
        . '<p><strong>Message:</strong><br>' . nl2br(esc_html($message)) . '</p>'
        . '<p><strong>Page URL:</strong> <a href="' . esc_url($page_url) . '" target="_blank">' . esc_html($page_url) . '</a></p>'
        . evodek_get_fb_ads_tracking_email_html()
		. '<hr>'
        . '<h3>Cart Items</h3>'
        . $cart_html
        . '<hr>'
        . '<p style="font-size:13px;color:#666;">'
        . '<strong>User IP:</strong> ' . esc_html($ip_address) . '<br>'
        . '<strong>Browser Info:</strong> ' . esc_html($user_agent)
        . '</p>';

	// Queensland 地区邮件追加专用头部与底部内容
    $email_body = evodek_wrap_qld_email($email_body, $state);

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $email,
    ];
	if (!empty($cc)) {
		$headers[] = 'Cc: ' . $cc;
	}

    if (wp_mail($to, $subject, $email_body, $headers)) {
        $_SESSION['cart'] = array();
        set_transient('cart_notice', 'The shopping cart contents have been sent successfully, we will contact you as soon as possible!', 30);
    } else {
        set_transient('cart_notice', 'Failed to send email, please try again later.', 30);
    }
}

// 6. 短代码：加入购物车按钮
add_shortcode('add_to_cart', 'add_to_cart_shortcode');
function add_to_cart_shortcode($atts) {
    $atts = shortcode_atts(array(
        'product_id' => get_the_ID(),
        'product_name' => get_the_title(),
    ), $atts);

    ob_start();
    ?>
    <form class="add-to-cart-form" method="post" action="">
        <input type="hidden" name="product_id" value="<?php echo esc_attr($atts['product_id']); ?>">
		<input type="hidden" name="product_name" value="<?php echo esc_attr($atts['product_name']); ?>">
        <input type="hidden" name="quantity" value="1">
        <button type="submit" class="btn btn-dark mycolor"><span class="d-flex align-items-center"><i class="fas fa-cart-plus mr-2"></i>Add to Cart</span></button>
    </form>
    <div class="cart-notice"></div>
    <?php
    return ob_get_clean();
}

// 7. 短代码：显示购物车内容
add_shortcode('cart', 'cart_shortcode');
function cart_shortcode() {
    ob_start();

    // 显示提示信息
    if ($notice = get_transient('cart_notice')) {
        echo '<div class="cart-notice">' . esc_html($notice) . '</div>';
        delete_transient('cart_notice');
    }

    if (empty($_SESSION['cart'])) {
        echo '<p style="text-align:center;margin:15px 0;font-size:18px">The shopping cart is empty.</p>';
        return ob_get_clean();
    }
    ?>

	<div class="container">
		<div class="row product-title">
			<div class="col-12">
				<h2>Your Cart</h2>
			</div>
		</div>
        
		<?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
			<form method="post" class="cart-form-single">
        		<div class="row product-card align-items-center">
					<div class="col-md-1 col-sm-2 col-4">
						<?php
                            // 使用 $product_id 获取产品自定义字段
							$pic01 = get_post_meta($product_id, 'product_pic01', true);
                        ?>
						<a target="_blank" href="<?php echo esc_url(get_permalink($product_id)); ?>">
							<img class="img-fluid" src="<?php echo esc_url($pic01); ?>" alt="Product Image">
						</a>
					</div>

					<div class="col-md-11 col-sm-10 col-8 pl-0">
						<div class="row">
							<div class="col-md-8 col-12 d-flex align-items-center my-2">
								<h3>
									<a target="_blank" href="<?php echo esc_url(get_permalink($product_id)); ?>">
										<?php echo esc_html($item['product_name']); ?>
									</a>
								</h3>
							</div>
							<div class="col-md-4 col-12 d-flex justify-content-between align-items-center my-2">
								<input type="number" name="cart[<?php echo esc_attr($product_id); ?>][quantity]" class="form-control quantity-input" value="<?php echo esc_attr($item['quantity']); ?>" min="1">
								<div class="input-group-append">
									<button type="submit" class="btn btn-outline-secondary update-item">Update</button>
									<button type="button" class="btn btn-outline-secondary remove-item" data-product-id="<?php echo esc_attr($product_id); ?>">Delete</button>
								</div>
							</div>
						</div>
					</div>
					<div class="cart-notice mt-2"></div>
        		</div>
			</form>
		<?php endforeach; ?>
	</div>

	<div class="container my-4">
		<form class="cart-submit-form mt-4" method="post">
			<?php wp_nonce_field('cart_submit_nonce', 'cart_submit_nonce'); ?>
			<h3 class="mb-3">Fill in your contact information</h3>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="customer_name"><strong>Name</strong></label>
					<input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Please enter your name" required>
				</div>
				<div class="form-group col-md-6">
					<label for="customer_phone"><strong>Phone</strong></label>
					<input type="tel" name="customer_phone" id="customer_phone" class="form-control" placeholder="Please enter your phone number" required>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="customer_email"><strong>Email</strong></label>
					<input type="email" name="customer_email" id="customer_email" class="form-control" placeholder="Please enter your email" required>
				</div>
				<div class="form-group col-md-6">
					<label for="state"><strong>State</strong></label>
					<select name="state" id="state" class="form-control" required>
						<?php echo evodek_render_state_options(); ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="customer_message"><strong>Message</strong></label>
				<textarea name="customer_message" id="customer_message" class="form-control" rows="4" placeholder="Please enter your message"></textarea>
			</div>

			<button type="submit" name="submit_cart" class="btn btn-secondary btn-block">Submit Cart</button>
		</form>
	</div>

    <?php
    return ob_get_clean();
}

// 创建迷你购物车图标的短代码
// 将迷你购物车图标封装为一个 WordPress 短代码 [mini_cart]，并在任何页面或帖子中调用它，方便地显示购物车图标及其数量。同时，您可以自由控制其样式和位置。
function mini_cart_shortcode() {
    ob_start();  // 启动输出缓冲区
    // 获取购物车中的产品数量
    $cart_count = get_cart_count();
    ?>
		<div class="cart-icon">
			<a href="<?php echo esc_url(home_url('/cart/')); ?>" class="cart-icon">
				<i class="fas fa-shopping-cart"></i>
				<span class="cart-count"><?php echo $cart_count; ?></span>
			</a>
		</div>
    <?php
    return ob_get_clean();  // 返回生成的 HTML 内容
}
add_shortcode('mini_cart', 'mini_cart_shortcode'); // 注册一个新的短代码 [mini_cart]，并将其与 mini_cart_shortcode 函数关联
// 在模板文件中直接调用短代码：echo do_shortcode('[mini_cart]');

// 9. 辅助函数：获取购物车产品总数
function get_cart_count() {
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) return 0;

    $count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $count += intval($item['quantity']);
    }
    return $count;
}
// 10. AJAX处理：获取购物车总数
add_action('wp_ajax_get_cart_count', 'ajax_get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'ajax_get_cart_count');
function ajax_get_cart_count() {
    check_ajax_referer('cart_nonce', 'nonce');
    wp_send_json_success(array('cart_count' => get_cart_count()));
}

// 11. 删除购物车产品
add_action('wp_ajax_remove_cart_item', 'ajax_remove_cart_item');
add_action('wp_ajax_nopriv_remove_cart_item', 'ajax_remove_cart_item');
function ajax_remove_cart_item() {
    check_ajax_referer('cart_nonce', 'nonce');
    $product_id = sanitize_text_field($_POST['product_id']);
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        wp_send_json_success(array('message' => 'This product has been removed.'));
		wp_die();
    } else {
        wp_send_json_error(array('message' => 'The product could not be found.'));
		wp_die();
    }
}

// 12. 清理Session
add_action('wp_logout', 'destroy_session');
function destroy_session() {
    if (session_id()) {
        session_destroy();
    }
}
// 购物车功能-结束

// === 地板墙板的产品配件计算功能-开始 ===
add_action('wp_ajax_send_calc_email', 'handle_send_calc_email');
add_action('wp_ajax_nopriv_send_calc_email', 'handle_send_calc_email');
function handle_send_calc_email() {
    check_ajax_referer('calc_email_nonce', 'calc_email_nonce');

    $name      = sanitize_text_field($_POST['name'] ?? '');
    $email     = sanitize_email($_POST['email'] ?? '');
    $phone     = sanitize_text_field($_POST['phone'] ?? '');
    $state     = sanitize_text_field($_POST['state'] ?? '');
    $message   = sanitize_textarea_field($_POST['message'] ?? '');
    $items     = sanitize_textarea_field($_POST['items'] ?? '');
    $calc_type = isset($_POST['calc_type']) ? sanitize_text_field($_POST['calc_type']) : 'Unknown Calculator';
    $page_url  = isset($_POST['page_url']) ? esc_url_raw($_POST['page_url']) : '';
    $user_agent = isset($_POST['user_agent']) ? sanitize_textarea_field($_POST['user_agent']) : '';

    if (!$name || !$email || !$state || !$items) {
        wp_send_json_error('Please complete all required fields.');
    }

    if (!is_email($email)) {
        wp_send_json_error('Please enter a valid email address.');
    }

    $ip = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $forwarded_ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($forwarded_ips[0]);
    } else {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    }

	$to = evodek_get_recipient_by_state($state);
	$cc = evodek_get_cc_by_state($state);

    $subject = $calc_type . ' Submission - ' . $state;

    $body = ''
        . '<h3>Calculator Info</h3>'
        . '<p><strong>Type:</strong> ' . esc_html($calc_type) . '</p>'
        . '<hr>'
        . '<h3>Sender Info</h3>'
        . '<p><strong>Name:</strong> ' . esc_html($name) . '</p>'
        . '<p><strong>Email:</strong> ' . esc_html($email) . '</p>'
        . '<p><strong>Phone:</strong> ' . esc_html($phone) . '</p>'
        . '<p><strong>State:</strong> ' . esc_html($state) . '</p>'
        . '<p><strong>Message:</strong><br>' . nl2br(esc_html($message)) . '</p>'
        . '<p><strong>Page URL:</strong> <a href="' . esc_url($page_url) . '" target="_blank">' . esc_html($page_url) . '</a></p>'
        . evodek_get_fb_ads_tracking_email_html()
		. '<p><strong>Client IP:</strong> ' . esc_html($ip) . '</p>'
        . '<p><strong>User Agent:</strong> ' . esc_html($user_agent) . '</p>'
        . '<hr>'
        . '<h3>Calculation Result</h3>'
        . '<pre style="font-family:monospace;">' . esc_html($items) . '</pre>';

	// Queensland 地区邮件追加专用头部与底部内容
    $body = evodek_wrap_qld_email($body, $state);

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $email,
    ];
	if (!empty($cc)) {
		$headers[] = 'Cc: ' . $cc;
	}

    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success('The message was sent successfully');
    } else {
        wp_send_json_error('Failed to send email');
    }

    wp_die();
}
// === 地板墙板的产品配件计算功能-结束 ===

// === 联系我们页和代理商页的表单提交-开始 ===
add_action('wp_ajax_send_contact_us_email', 'send_contact_us_email_callback');
add_action('wp_ajax_nopriv_send_contact_us_email', 'send_contact_us_email_callback');

// === Facebook 广告来源全站记录-开始 ===
// 广告落地页只需要带 ?fb_ads=1，例如：https://www.abc.com/?fb_ads=1
// 服务器端也记录一次，作为隐藏字段 / JS 未提交成功时的兜底方案。
add_action('init', 'evodek_capture_fb_ads_tracking_server_side', 2);
function evodek_capture_fb_ads_tracking_server_side() {
    if (is_admin()) {
        return;
    }

    if (!isset($_SESSION) || !is_array($_SESSION)) {
        return;
    }

    $current_url = esc_url_raw(home_url(add_query_arg(array(), $_SERVER['REQUEST_URI'] ?? '/')));

    if (empty($_SESSION['evodek_first_landing_page'])) {
        $_SESSION['evodek_first_landing_page'] = $current_url;
    }

    if (isset($_GET['fb_ads']) && sanitize_text_field(wp_unslash($_GET['fb_ads'])) === '1') {
        $_SESSION['evodek_facebook_ads'] = 'Yes';
        $_SESSION['evodek_fb_ads_landing_page'] = $current_url;
    }
}

// 这段脚本通过 wp_footer 输出到全站页面，确保用户先进入首页/产品页，再跳转到任意表单页时，来源标记不会丢失。
// 说明：
// 1. 本脚本会自动把隐藏字段补充到页面上的所有 form 中；
// 2. 如果表单里已经手动添加了同名隐藏字段，则不会重复添加；
// 3. Ajax 表单如果使用 serializeArray() / FormData(form) 提交，会自动带上这些字段；如果手动 new FormData()，需要在对应 JS 中 append 这些字段。
add_action('wp_footer', 'evodek_output_fb_ads_tracking_script');
function evodek_output_fb_ads_tracking_script() {
    if (is_admin()) {
        return;
    }
    ?>
    <script>
    (function () {
        var trackingFieldNames = [
            'facebook_ads',
            'first_landing_page',
            'fb_ads_landing_page'
        ];

        function ensureTrackingFieldsInForms() {
            var forms = document.querySelectorAll('form');

            forms.forEach(function (form) {
                trackingFieldNames.forEach(function (name) {
                    if (!form.querySelector('[name="' + name + '"]')) {
                        var input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = name;
                        input.className = 'evodek-fb-ads-tracking-field';
                        form.appendChild(input);
                    }
                });
            });
        }

        function setTrackingField(name, value) {
            var fields = document.querySelectorAll('[name="' + name + '"]');

            fields.forEach(function (field) {
                field.value = value || '';
            });
        }

        var params = new URLSearchParams(window.location.search);

        // 记录用户本次浏览会话中第一次进入网站的页面。
        if (!sessionStorage.getItem('first_landing_page')) {
            sessionStorage.setItem('first_landing_page', window.location.href);
        }

        // 只要任意页面 URL 中出现 fb_ads=1，就把本次会话标记为 Facebook 广告来源。
        if (params.get('fb_ads') === '1') {
            sessionStorage.setItem('facebook_ads', 'Yes');
            sessionStorage.setItem('fb_ads_landing_page', window.location.href);
        }

        var facebookAds = sessionStorage.getItem('facebook_ads') === 'Yes' ? 'Yes' : 'No';
        var firstLandingPage = sessionStorage.getItem('first_landing_page') || window.location.href;
        var fbAdsLandingPage = sessionStorage.getItem('fb_ads_landing_page') || '';

        // 暴露给手动构建 FormData 的 JS 使用，例如免费样品页的自定义提交脚本。
        window.evodekFbAdsTracking = {
            facebook_ads: facebookAds,
            first_landing_page: firstLandingPage,
            fb_ads_landing_page: fbAdsLandingPage
        };

        // 先给所有表单自动补充隐藏字段，再统一写入值。
        ensureTrackingFieldsInForms();
        setTrackingField('facebook_ads', facebookAds);
        setTrackingField('first_landing_page', firstLandingPage);
        setTrackingField('fb_ads_landing_page', fbAdsLandingPage);
    })();
    </script>
    <?php
}

// 输出 Facebook 广告来源隐藏字段。
// 如果你想在模板中手动添加，也可以直接调用：<?php echo evodek_get_fb_ads_tracking_hidden_fields();
function evodek_get_fb_ads_tracking_hidden_fields() {
    return ''
        . '<input type="hidden" name="facebook_ads" value="No">' . "\n"
        . '<input type="hidden" name="first_landing_page" value="">' . "\n"
        . '<input type="hidden" name="fb_ads_landing_page" value="">' . "\n";
}

// 从 $_POST 中统一读取 Facebook 广告来源字段。
// 优先读取表单提交字段；如果字段没有提交，则回退到 PHP Session 中记录的来源。
function evodek_get_fb_ads_tracking_data_from_post() {
    $posted_facebook_ads        = sanitize_text_field($_POST['facebook_ads'] ?? 'No');
    $posted_first_landing_page  = esc_url_raw($_POST['first_landing_page'] ?? '');
    $posted_fb_ads_landing_page = esc_url_raw($_POST['fb_ads_landing_page'] ?? '');
    $posted_page_url            = esc_url_raw($_POST['page_url'] ?? '');

    $session_facebook_ads        = sanitize_text_field($_SESSION['evodek_facebook_ads'] ?? 'No');
    $session_first_landing_page  = esc_url_raw($_SESSION['evodek_first_landing_page'] ?? '');
    $session_fb_ads_landing_page = esc_url_raw($_SESSION['evodek_fb_ads_landing_page'] ?? '');

    $first_landing_page  = $posted_first_landing_page ?: $session_first_landing_page;
    $fb_ads_landing_page = $posted_fb_ads_landing_page ?: $session_fb_ads_landing_page;

    $facebook_ads = ($posted_facebook_ads === 'Yes' || $session_facebook_ads === 'Yes') ? 'Yes' : 'No';

    // 兜底判断：如果提交页或落地页 URL 中仍然带 fb_ads=1，也直接识别为 Facebook Ads。
    $combined_urls = $posted_page_url . ' ' . $first_landing_page . ' ' . $fb_ads_landing_page;
    if ($facebook_ads !== 'Yes' && strpos($combined_urls, 'fb_ads=1') !== false) {
        $facebook_ads = 'Yes';

        if (!$fb_ads_landing_page) {
            $fb_ads_landing_page = $posted_page_url ?: $first_landing_page;
        }
    }

    return [
        'facebook_ads'        => $facebook_ads,
        'first_landing_page'  => $first_landing_page,
        'fb_ads_landing_page' => $fb_ads_landing_page,
    ];
}

// 邮件中使用的链接输出工具。
function evodek_render_email_url_line($label, $url) {
    $url = esc_url_raw($url);

    if (!$url) {
        return '<p><strong>' . esc_html($label) . ':</strong> </p>';
    }

    return '<p><strong>' . esc_html($label) . ':</strong> <a href="' . esc_url($url) . '" target="_blank">' . esc_html($url) . '</a></p>';
}

// 统一生成 Facebook 广告来源邮件区块。
function evodek_get_fb_ads_tracking_email_html() {
    $tracking = evodek_get_fb_ads_tracking_data_from_post();

    return ''
        . '<hr>'
        . '<h3>Facebook Ads Tracking</h3>'
        . '<p><strong>Facebook Ads:</strong> ' . esc_html($tracking['facebook_ads']) . '</p>'
        . evodek_render_email_url_line('First Landing Page', $tracking['first_landing_page'])
        . evodek_render_email_url_line('Facebook Ads Landing Page', $tracking['fb_ads_landing_page']);
}
// === Facebook 广告来源全站记录-结束 ===

function send_contact_us_email_callback() {
    check_ajax_referer('contact_us_nonce', 'contact_us_nonce');

    $name     = sanitize_text_field($_POST['name'] ?? '');
    $email    = sanitize_email($_POST['email'] ?? '');
    $phone    = sanitize_text_field($_POST['phone'] ?? '');
    $state    = sanitize_text_field($_POST['state'] ?? '');
    $subject  = sanitize_text_field($_POST['subject'] ?? '');
    $message  = sanitize_textarea_field($_POST['message'] ?? '');
    $page_url = esc_url_raw($_POST['page_url'] ?? '');

    if (!$name || !$email || !$state || !$subject || !$message) {
        wp_send_json_error([
            'msg' => 'Please complete all required fields.'
        ]);
    }

    if (!is_email($email)) {
        wp_send_json_error([
            'msg' => 'Please enter a valid email address.'
        ]);
    }

    $to = evodek_get_recipient_by_state($state);
	$cc = evodek_get_cc_by_state($state);

    // 获取用户真实 IP
    $client_ip = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $client_ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $forwarded_ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $client_ip = trim($forwarded_ips[0]);
    } else {
        $client_ip = $_SERVER['REMOTE_ADDR'] ?? '';
    }

    $mail_subject = 'Contact Us - ' . $state . ' - ' . $subject;

    $body = ''
        . '<p><strong>Name:</strong> ' . esc_html($name) . '</p>'
        . '<p><strong>Email:</strong> ' . esc_html($email) . '</p>'
        . '<p><strong>Phone:</strong> ' . esc_html($phone) . '</p>'
        . '<p><strong>State:</strong> ' . esc_html($state) . '</p>'
        . '<p><strong>Subject:</strong> ' . esc_html($subject) . '</p>'
        . '<p><strong>Message:</strong><br>' . nl2br(esc_html($message)) . '</p>'
        . '<br>'
        . '<p><strong>IP Address:</strong> ' . esc_html($client_ip) . '</p>'
        . '<p><strong>Page URL:</strong> <a href="' . esc_url($page_url) . '" target="_blank">' . esc_html($page_url) . '</a></p>'
        . evodek_get_fb_ads_tracking_email_html()
		. '<p><strong>Submitted At:</strong> ' . esc_html(current_time('mysql')) . '</p>';

	// Queensland 地区邮件追加专用头部与底部内容
    $body = evodek_wrap_qld_email($body, $state);

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $email,
    ];
	if (!empty($cc)) {
		$headers[] = 'Cc: ' . $cc;
	}

    $sent = wp_mail($to, $mail_subject, $body, $headers);

    // error_log('CONTACT MAIL STATE: ' . $state);
    // error_log('CONTACT MAIL TO: ' . $to);
    // error_log('CONTACT MAIL RESULT: ' . ($sent ? 'true' : 'false'));

    if ($sent) {
        wp_send_json_success([
            'msg' => 'Thank you! Your form has been submitted successfully.'
        ]);
    } else {
        wp_send_json_error([
            'msg' => 'Email sending failed. Please check your server mail configuration or SMTP settings.'
        ]);
    }

    wp_die();
}
// === 联系我们页和代理商页的表单提交-结束 ===

// === 免费样品页的表单提交-开始 ===
add_action('wp_ajax_evodek_submit_sample_request', 'evodek_submit_sample_request_callback');
add_action('wp_ajax_nopriv_evodek_submit_sample_request', 'evodek_submit_sample_request_callback');

function evodek_normalize_sample_region($region) {
    $map = [
        'VIC' => 'Victoria',
        'QLD' => 'Queensland',
        'NSW' => 'New South Wales',
        'SA'  => 'South Australia',
        'WA'  => 'Western Australia',
    ];

    $region = sanitize_text_field($region);
    return $map[$region] ?? $region;
}

function evodek_get_client_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return sanitize_text_field($_SERVER['HTTP_CLIENT_IP']);
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $forwarded_ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return sanitize_text_field(trim($forwarded_ips[0]));
    }

    return sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
}

function evodek_submit_sample_request_callback() {
    check_ajax_referer('evodek_sample_request_nonce', 'sample_request_nonce');

    $identity                = sanitize_text_field($_POST['identity'] ?? '');
    $identity_label          = sanitize_text_field($_POST['identity_label'] ?? '');
    $installer_abn           = sanitize_text_field($_POST['installer_abn'] ?? '');
    $installer_business_name = sanitize_text_field($_POST['installer_business_name'] ?? '');
    $region_code             = sanitize_text_field($_POST['region'] ?? '');
    $first_name              = sanitize_text_field($_POST['first_name'] ?? '');
    $last_name               = sanitize_text_field($_POST['last_name'] ?? '');
    $phone                   = sanitize_text_field($_POST['phone'] ?? '');
    $email                   = sanitize_email($_POST['email'] ?? '');
    $address                 = sanitize_text_field($_POST['address'] ?? '');
    $street_address          = sanitize_text_field($_POST['street_address'] ?? '');
    $message                 = sanitize_textarea_field($_POST['message'] ?? '');
    $privacy_consent         = sanitize_text_field($_POST['privacy_consent'] ?? '');
    $page_url                = esc_url_raw($_POST['page_url'] ?? '');
    $user_agent              = sanitize_textarea_field($_POST['user_agent'] ?? '');

    $products_json = wp_unslash($_POST['products'] ?? '[]');
    $products      = json_decode($products_json, true);

    if (!is_array($products)) {
        $products = [];
    }

    if (
        !$identity ||
        !$region_code ||
        !$first_name ||
        !$last_name ||
        !$phone ||
        !$email ||
        !$address ||
        !$street_address ||
        $privacy_consent !== 'yes'
    ) {
        wp_send_json_error([
            'msg' => 'Please complete all required fields.'
        ]);
    }

    if (!is_email($email)) {
        wp_send_json_error([
            'msg' => 'Please enter a valid email address.'
        ]);
    }

    if (
        ($identity === 'professional_installer' || $identity === 'architect_designer') &&
        (!$installer_abn || !$installer_business_name)
    ) {
        wp_send_json_error([
            'msg' => 'ABN and Business Name are required for installers / designers / architects.'
        ]);
    }

    if (empty($products)) {
        wp_send_json_error([
            'msg' => 'Please select at least one product and color.'
        ]);
    }

    $normalized_state = evodek_normalize_sample_region($region_code);
    $to = evodek_get_recipient_by_state($normalized_state);
    $cc = evodek_get_cc_by_state($normalized_state);

    $product_rows = '';
    foreach ($products as $item) {
        $product_name = esc_html($item['name'] ?? '');
        $product_model = esc_html($item['model'] ?? '');
        $colors = [];

        if (!empty($item['colors']) && is_array($item['colors'])) {
            foreach ($item['colors'] as $color) {
                $colors[] = esc_html($color);
            }
        }

        $color_text = !empty($colors) ? implode(', ', $colors) : 'No colors selected';

        $product_rows .= ''
            . '<tr>'
            . '<td style="padding:8px;border:1px solid #ddd;">' . $product_name . '</td>'
            . '<td style="padding:8px;border:1px solid #ddd;">' . $product_model . '</td>'
            . '<td style="padding:8px;border:1px solid #ddd;">' . $color_text . '</td>'
            . '</tr>';
    }

    $client_ip = evodek_get_client_ip();
    $full_name = trim($first_name . ' ' . $last_name);
    $mail_subject = 'Free Samples Request - ' . $normalized_state . ' - ' . $full_name;

    $body = ''
        . '<h2>New Free Samples Request</h2>'
        . '<h3>Applicant Information</h3>'
        . '<p><strong>Identity:</strong> ' . esc_html($identity_label ?: $identity) . '</p>'
        . '<p><strong>First Name:</strong> ' . esc_html($first_name) . '</p>'
        . '<p><strong>Last Name:</strong> ' . esc_html($last_name) . '</p>'
        . '<p><strong>Phone:</strong> ' . esc_html($phone) . '</p>'
        . '<p><strong>Email:</strong> ' . esc_html($email) . '</p>'
        . '<p><strong>Region:</strong> ' . esc_html($region_code) . ' (' . esc_html($normalized_state) . ')</p>'
        . '<p><strong>Address / Suburb:</strong> ' . esc_html($address) . '</p>'
        . '<p><strong>Street Address:</strong> ' . esc_html($street_address) . '</p>';

    if ($identity === 'professional_installer' || $identity === 'architect_designer') {
        $body .= ''
            . '<p><strong>ABN:</strong> ' . esc_html($installer_abn) . '</p>'
            . '<p><strong>Business Name:</strong> ' . esc_html($installer_business_name) . '</p>';
    }

    $body .= ''
        . '<p><strong>Message:</strong><br>' . nl2br(esc_html($message)) . '</p>'
        . '<hr>'
        . '<h3>Selected Products</h3>'
        . '<table style="border-collapse:collapse;width:100%;max-width:900px;">'
        . '<thead>'
        . '<tr>'
        . '<th style="padding:8px;border:1px solid #ddd;text-align:left;">Product</th>'
        . '<th style="padding:8px;border:1px solid #ddd;text-align:left;">Model</th>'
        . '<th style="padding:8px;border:1px solid #ddd;text-align:left;">Colors</th>'
        . '</tr>'
        . '</thead>'
        . '<tbody>'
        . $product_rows
        . '</tbody>'
        . '</table>'
        . '<hr>'
        . '<h3>Submission Info</h3>'
        . '<p><strong>Privacy Consent:</strong> Yes</p>'
        . '<p><strong>Page URL:</strong> <a href="' . esc_url($page_url) . '" target="_blank">' . esc_html($page_url) . '</a></p>'
        . evodek_get_fb_ads_tracking_email_html()
        . '<p><strong>Client IP:</strong> ' . esc_html($client_ip) . '</p>'
        . '<p><strong>User Agent:</strong> ' . esc_html($user_agent) . '</p>'
        . '<p><strong>Submitted At:</strong> ' . esc_html(current_time('mysql')) . '</p>';

	// Queensland 地区邮件追加专用头部与底部内容
    $body = evodek_wrap_qld_email($body, $normalized_state);

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $email,
    ];

    if (!empty($cc)) {
        $headers[] = 'Cc: ' . $cc;
    }

    $sent = wp_mail($to, $mail_subject, $body, $headers);

    if ($sent) {
        wp_send_json_success([
            'msg' => 'Thank you! Your sample request has been submitted successfully.'
        ]);
    } else {
        wp_send_json_error([
            'msg' => 'Email sending failed. Please check your SMTP or mail configuration.'
        ]);
    }

    wp_die();
}
// === 免费样品页的表单提交-结束 ===
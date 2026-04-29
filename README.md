# WordPress 表单 Facebook 广告来源追踪指南

这是一个适用于 WordPress 自定义主题表单的简化版 Facebook / Meta 广告来源追踪方案。

目标很简单：

> 用户从 Facebook 广告进入网站并提交表单后，询盘邮件中显示 `Facebook Ads: Yes`；非广告来源则显示 `Facebook Ads: No`。

同时，本方案还会记录：

- 用户第一次进入网站的页面
- 带有 `fb_ads=1` 参数的 Facebook 广告落地页
- 用户最终提交表单的页面

---

## 适用场景

适合以下情况：

- WordPress 自定义主题
- 表单通过 Ajax 提交
- 表单最终通过 `wp_mail()` 发送到邮箱
- 不想接入复杂的 GA4 / Google Tag Manager / Meta Pixel 转化统计
- 只想在邮件里快速判断询盘是否来自 Facebook 广告

---

## 实现原理

广告链接中添加一个最简单的参数：

```txt
fb_ads=1
```

例如：

```txt
https://www.example.com/contact-us/?fb_ads=1
```

或者：

```txt
https://www.example.com/product-page/?fb_ads=1
```

当用户访问带有 `fb_ads=1` 的页面时，前端 JavaScript 会把来源信息保存到浏览器的 `sessionStorage` 中；为了兼容旧版本，也可以同时读取 `localStorage`。

这样即使用户不是在广告落地页直接提交表单，而是先浏览其他页面，再进入 Contact 页面提交表单，也仍然可以识别为 Facebook 广告来源。

示例路径：

```txt
1. 用户点击 Facebook 广告
2. 进入 https://www.example.com/product-page/?fb_ads=1
3. 浏览其他页面
4. 进入 https://www.example.com/contact-us/
5. 提交表单
6. 邮件中显示 Facebook Ads: Yes
```


### 最终增强版推荐架构

经过多表单测试后，推荐使用下面这套更稳的组合：

| 模块 | 作用 |
|---|---|
| 前端 `sessionStorage` | 记录本次浏览会话中的 Facebook 广告来源 |
| 全站 `wp_footer` 脚本 | 自动给页面里的所有表单补充隐藏字段 |
| `window.evodekFbAdsTracking` | 给免费样品页、多步骤表单、手动 `new FormData()` 的 JS 读取使用 |
| PHP Session | 服务器端兜底，防止部分表单漏传隐藏字段 |
| 统一邮件函数 | 所有表单邮件统一输出 `Facebook Ads Tracking` 区块 |

这种方式可以覆盖：

- Contact Us / 代理商表单
- 购物车提交表单
- Decking Calculator 表单
- Cladding Calculator 表单
- Free Samples 免费样品多步骤表单

---

## 增强版：服务器端 PHP Session 兜底

如果主题里已经有购物车功能，并且已经启用了 PHP Session，可以直接复用。

如果没有，可以先添加：

```php
add_action('init', 'theme_start_session', 1);

function theme_start_session() {
    if (!session_id()) {
        session_start();
    }
}
```

然后添加服务器端兜底记录：

```php
add_action('init', 'theme_capture_fb_ads_tracking_server_side', 2);

function theme_capture_fb_ads_tracking_server_side() {
    if (is_admin()) {
        return;
    }

    if (!isset($_SESSION) || !is_array($_SESSION)) {
        return;
    }

    $current_url = esc_url_raw(home_url(add_query_arg(array(), $_SERVER['REQUEST_URI'] ?? '/')));

    if (empty($_SESSION['theme_first_landing_page'])) {
        $_SESSION['theme_first_landing_page'] = $current_url;
    }

    if (isset($_GET['fb_ads']) && sanitize_text_field(wp_unslash($_GET['fb_ads'])) === '1') {
        $_SESSION['theme_facebook_ads'] = 'Yes';
        $_SESSION['theme_fb_ads_landing_page'] = $current_url;
    }
}
```

这一步的作用是：即使某个 Ajax 表单没有把隐藏字段提交到后台，PHP 仍然可以尝试从 Session 中识别广告来源。

---

## 增强版：自动给所有表单补隐藏字段

如果网站有很多表单页面，不想每个页面手动添加隐藏域，可以让全站脚本自动补充字段。

核心逻辑如下：

```js
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
        input.className = 'theme-fb-ads-tracking-field';
        form.appendChild(input);
      }
    });
  });
}
```

同时建议在全站脚本里暴露一个全局对象：

```js
window.evodekFbAdsTracking = {
  facebook_ads: facebookAds,
  first_landing_page: firstLandingPage,
  fb_ads_landing_page: fbAdsLandingPage
};
```

这样免费样品页这类独立 JS 文件也能读取到广告来源数据。

---

## Meta / Facebook 广告后台参数设置

如果广告落地页是：

```txt
https://www.example.com/contact-us/
```

完整 URL 可以写成：

```txt
https://www.example.com/contact-us/?fb_ads=1
```

如果 Meta 广告后台有单独的 **URL Parameters** 输入框，只需要填写：

```txt
fb_ads=1
```

不需要填写复杂的 UTM 参数。

---

## 最终邮件显示效果

Facebook 广告来的询盘：

```txt
Facebook Ads: Yes
First Landing Page: https://www.example.com/product-page/?fb_ads=1
Facebook Ads Landing Page: https://www.example.com/product-page/?fb_ads=1
Submitted Page URL: https://www.example.com/contact-us/
```

非 Facebook 广告来的询盘：

```txt
Facebook Ads: No
First Landing Page: https://www.example.com/contact-us/
Facebook Ads Landing Page:
Submitted Page URL: https://www.example.com/contact-us/
```

---

## 第一步：在 functions.php 中加入全站追踪脚本

将以下代码添加到主题的 `functions.php` 文件中。

建议放在表单相关函数附近，或者文件底部。

```php
/**
 * 全站记录 Facebook 广告来源
 *
 * 广告链接示例：
 * https://www.example.com/contact-us/?fb_ads=1
 */
add_action('wp_footer', 'theme_output_fb_ads_tracking_script');

function theme_output_fb_ads_tracking_script() {
    if (is_admin()) {
        return;
    }
    ?>
    <script>
    (function () {
        var params = new URLSearchParams(window.location.search);
        var hasFbAdsParam = params.get('fb_ads') === '1';
        var currentUrl = window.location.href;

        // 记录用户第一次进入网站的页面
        if (!localStorage.getItem('first_landing_page')) {
            localStorage.setItem('first_landing_page', currentUrl);
        }

        // 如果当前页面 URL 中带有 fb_ads=1，则标记为 Facebook 广告来源
        if (hasFbAdsParam) {
            localStorage.setItem('facebook_ads', 'Yes');
            localStorage.setItem('fb_ads_landing_page', currentUrl);
        } else if (!localStorage.getItem('facebook_ads')) {
            localStorage.setItem('facebook_ads', 'No');
        }

        function setField(id, value) {
            var field = document.getElementById(id);
            if (field) {
                field.value = value || '';
            }
        }

        // 自动填充表单隐藏字段
        setField('facebook_ads', localStorage.getItem('facebook_ads') || 'No');
        setField('first_landing_page', localStorage.getItem('first_landing_page') || '');
        setField('fb_ads_landing_page', localStorage.getItem('fb_ads_landing_page') || '');
    })();
    </script>
    <?php
}
```

### 为什么脚本要放到 functions.php？

因为脚本需要在全站运行。

如果只放在 Contact 页面，当用户先进入产品页：

```txt
https://www.example.com/product-page/?fb_ads=1
```

然后再进入 Contact 页面提交表单，Contact 页面就无法知道用户最初是从广告进来的。

通过 `wp_footer` 输出到全站，就可以在用户第一次进入网站时立即记录来源。

---

## 第二步：在表单页面加入隐藏字段

在表单提交按钮之前加入以下隐藏字段。

```html
<input type="hidden" name="facebook_ads" id="facebook_ads" value="No">
<input type="hidden" name="first_landing_page" id="first_landing_page">
<input type="hidden" name="fb_ads_landing_page" id="fb_ads_landing_page">
```

示例：

```html
<form id="contactus" class="mb-4">
    <!-- 其他表单字段 -->

    <input type="hidden" name="facebook_ads" id="facebook_ads" value="No">
    <input type="hidden" name="first_landing_page" id="first_landing_page">
    <input type="hidden" name="fb_ads_landing_page" id="fb_ads_landing_page">

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
```

如果你的表单使用的是 jQuery Ajax，并通过下面这种方式收集字段：

```js
var formData = $form.serializeArray();
```

那么新增的隐藏字段会自动随表单一起提交，不需要额外处理。

---

## 第三步：Ajax 提交时保留最终提交页面 URL

如果你的 Ajax 里已经有类似代码，可以保留：

```js
formData.push({ name: 'page_url', value: window.location.href });
```

完整示例：

```js
jQuery(function($){
    $('#contactus').on('submit', function(e){
        e.preventDefault();

        var $form = $(this);
        var $btn  = $form.find('button[type="submit"]');

        if ($btn.prop('disabled')) {
            return;
        }

        var formData = $form.serializeArray();
        formData.push({ name: 'action', value: 'send_contact_us_email' });
        formData.push({ name: 'page_url', value: window.location.href });

        $.ajax({
            url: ajaxurl_or_admin_ajax_url,
            type: 'POST',
            dataType: 'json',
            data: $.param(formData),
            beforeSend: function(){
                $btn.prop('disabled', true).text('Sending...');
            },
            success: function(res){
                if (res.success) {
                    alert(res.data.msg || 'Submitted successfully.');
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
```

注意：`ajaxurl_or_admin_ajax_url` 需要替换成你主题中的 Ajax 地址，例如：

```php
<?php echo esc_url(admin_url('admin-ajax.php')); ?>
```

---

---

## 第三步补充：手动 `new FormData()` 的表单需要额外处理

有些复杂表单并不是直接提交整个 `<form>`，也不是用：

```js
var formData = $form.serializeArray();
```

而是像免费样品页这种逻辑，在独立 JS 文件中手动创建：

```js
const formData = new FormData();
```

然后逐个添加字段：

```js
formData.append('action', 'evodek_submit_sample_request');
formData.append('first_name', payload.first_name || '');
formData.append('email', payload.email || '');
```

这种写法需要特别注意：

> 即使页面里已经有隐藏字段，如果 JS 没有把这些字段 `append()` 进去，Ajax 请求也不会提交这些 Facebook Ads 数据。

### 免费样品页这类表单的推荐处理方式

在独立 JS 文件中增加一个读取追踪数据的方法：

```js
function getFbAdsTrackingData() {
  function getFieldValue(fieldName) {
    const field = document.querySelector(`[name="${fieldName}"], #${fieldName}`);
    return field ? field.value : '';
  }

  const globalTracking = window.themeFbAdsTracking || window.evodekFbAdsTracking || {};

  return {
    facebook_ads:
      getFieldValue('facebook_ads') ||
      globalTracking.facebook_ads ||
      sessionStorage.getItem('facebook_ads') ||
      localStorage.getItem('facebook_ads') ||
      'No',

    first_landing_page:
      getFieldValue('first_landing_page') ||
      globalTracking.first_landing_page ||
      sessionStorage.getItem('first_landing_page') ||
      localStorage.getItem('first_landing_page') ||
      window.location.href,

    fb_ads_landing_page:
      getFieldValue('fb_ads_landing_page') ||
      globalTracking.fb_ads_landing_page ||
      sessionStorage.getItem('fb_ads_landing_page') ||
      localStorage.getItem('fb_ads_landing_page') ||
      ''
  };
}
```

然后在构建 Ajax `FormData` 时追加这 3 个字段：

```js
const fbAdsTracking = getFbAdsTrackingData();

formData.append('facebook_ads', fbAdsTracking.facebook_ads === 'Yes' ? 'Yes' : 'No');
formData.append('first_landing_page', fbAdsTracking.first_landing_page || '');
formData.append('fb_ads_landing_page', fbAdsTracking.fb_ads_landing_page || '');
```

完整示例：

```js
function buildAjaxFormData(payload) {
  const formData = new FormData();

  formData.append('action', 'evodek_submit_sample_request');
  formData.append('sample_request_nonce', ajaxNonce);

  formData.append('first_name', payload.first_name || '');
  formData.append('last_name', payload.last_name || '');
  formData.append('phone', payload.phone || '');
  formData.append('email', payload.email || '');
  formData.append('message', payload.message || '');

  formData.append('page_url', window.location.href);
  formData.append('user_agent', navigator.userAgent || '');

  const fbAdsTracking = getFbAdsTrackingData();
  formData.append('facebook_ads', fbAdsTracking.facebook_ads === 'Yes' ? 'Yes' : 'No');
  formData.append('first_landing_page', fbAdsTracking.first_landing_page || '');
  formData.append('fb_ads_landing_page', fbAdsTracking.fb_ads_landing_page || '');

  return formData;
}
```

### 判断规则

| 表单提交方式 | 是否自动带隐藏字段 | 是否需要手动 append |
|---|---:|---:|
| 普通表单提交 | 是 | 否 |
| `serializeArray()` | 是 | 否 |
| `FormData(form)` | 是 | 否 |
| `new FormData()` 后逐个 `append()` | 否 | 是 |

---

## 第三步补充：更新独立 JS 文件后要处理缓存

如果你修改了独立 JS 文件，例如：

```txt
/js/evodek-sample-request.js
```

浏览器或缓存插件可能仍然加载旧版本，导致新加的 Facebook Ads 字段没有生效。

### 简单做法：手动修改版本号

原来可能是：

```php
<script src="<?php echo esc_url( get_theme_file_uri('js/evodek-sample-request.js?v=1.0.3') ); ?>"></script>
```

修改 JS 后，把版本号改成新的：

```php
<script src="<?php echo esc_url( get_theme_file_uri('js/evodek-sample-request.js?v=1.0.4') ); ?>"></script>
```

### 推荐做法：使用 `filemtime()` 自动刷新版本

更推荐用文件修改时间作为版本号：

```php
<?php
$sample_js_file = 'js/evodek-sample-request.js';
$sample_js_path = get_theme_file_path($sample_js_file);
$sample_js_ver  = file_exists($sample_js_path) ? filemtime($sample_js_path) : '1.0.0';
?>
<script src="<?php echo esc_url( get_theme_file_uri($sample_js_file) . '?v=' . $sample_js_ver ); ?>"></script>
```

这样每次你上传并覆盖 `evodek-sample-request.js` 后，只要文件修改时间变了，前端就会自动加载新版 JS。

### WordPress enqueue 写法

如果你的主题使用 `wp_enqueue_script()`，可以这样写：

```php
add_action('wp_enqueue_scripts', 'theme_enqueue_sample_request_script');

function theme_enqueue_sample_request_script() {
    $file = 'js/evodek-sample-request.js';
    $path = get_theme_file_path($file);
    $ver  = file_exists($path) ? filemtime($path) : '1.0.0';

    wp_enqueue_script(
        'evodek-sample-request',
        get_theme_file_uri($file),
        [],
        $ver,
        true
    );
}
```

### 测试时的建议

修改 JS 后建议同时做这几件事：

1. 页面源码中确认 JS 地址后面的 `v=` 已经变化。
2. 浏览器按 `Ctrl + F5` 强制刷新。
3. 使用无痕窗口测试。
4. 如果网站有缓存插件或 CDN，清理页面缓存和静态资源缓存。


---

## 增强版：统一 PHP 邮件输出函数

建议把 Facebook Ads 邮件输出封装成统一函数，然后所有表单邮件都调用它。

```php
function theme_get_fb_ads_tracking_data_from_post() {
    $posted_facebook_ads        = sanitize_text_field($_POST['facebook_ads'] ?? 'No');
    $posted_first_landing_page  = esc_url_raw($_POST['first_landing_page'] ?? '');
    $posted_fb_ads_landing_page = esc_url_raw($_POST['fb_ads_landing_page'] ?? '');
    $posted_page_url            = esc_url_raw($_POST['page_url'] ?? '');

    $session_facebook_ads        = sanitize_text_field($_SESSION['theme_facebook_ads'] ?? 'No');
    $session_first_landing_page  = esc_url_raw($_SESSION['theme_first_landing_page'] ?? '');
    $session_fb_ads_landing_page = esc_url_raw($_SESSION['theme_fb_ads_landing_page'] ?? '');

    $first_landing_page  = $posted_first_landing_page ?: $session_first_landing_page;
    $fb_ads_landing_page = $posted_fb_ads_landing_page ?: $session_fb_ads_landing_page;

    $facebook_ads = ($posted_facebook_ads === 'Yes' || $session_facebook_ads === 'Yes') ? 'Yes' : 'No';

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

function theme_render_email_url_line($label, $url) {
    $url = esc_url_raw($url);

    if (!$url) {
        return '<p><strong>' . esc_html($label) . ':</strong> </p>';
    }

    return '<p><strong>' . esc_html($label) . ':</strong> <a href="' . esc_url($url) . '" target="_blank">' . esc_html($url) . '</a></p>';
}

function theme_get_fb_ads_tracking_email_html() {
    $tracking = theme_get_fb_ads_tracking_data_from_post();

    return ''
        . '<hr>'
        . '<h3>Facebook Ads Tracking</h3>'
        . '<p><strong>Facebook Ads:</strong> ' . esc_html($tracking['facebook_ads']) . '</p>'
        . theme_render_email_url_line('First Landing Page', $tracking['first_landing_page'])
        . theme_render_email_url_line('Facebook Ads Landing Page', $tracking['fb_ads_landing_page']);
}
```

邮件正文里只需要加入：

```php
. theme_get_fb_ads_tracking_email_html()
```

如果你的项目已经使用 `evodek_get_fb_ads_tracking_email_html()` 这个函数名，也可以继续沿用原来的命名。

## 第四步：在 PHP 邮件函数中接收字段

在处理表单提交的 PHP 函数中，添加以下字段接收代码。

```php
$facebook_ads        = sanitize_text_field($_POST['facebook_ads'] ?? 'No');
$first_landing_page  = esc_url_raw($_POST['first_landing_page'] ?? '');
$fb_ads_landing_page = esc_url_raw($_POST['fb_ads_landing_page'] ?? '');
$page_url            = esc_url_raw($_POST['page_url'] ?? '');
```

建议对 `facebook_ads` 做一次规范化处理，避免异常值：

```php
$facebook_ads = ($facebook_ads === 'Yes') ? 'Yes' : 'No';
```

---

## 第五步：把 Facebook 来源信息加入邮件内容

在邮件正文 `$body` 中加入以下内容。

```php
$body .= ''
    . '<br>'
    . '<p><strong>Facebook Ads:</strong> ' . esc_html($facebook_ads) . '</p>'
    . '<p><strong>First Landing Page:</strong> '
    . ($first_landing_page ? '<a href="' . esc_url($first_landing_page) . '" target="_blank">' . esc_html($first_landing_page) . '</a>' : '')
    . '</p>'
    . '<p><strong>Facebook Ads Landing Page:</strong> '
    . ($fb_ads_landing_page ? '<a href="' . esc_url($fb_ads_landing_page) . '" target="_blank">' . esc_html($fb_ads_landing_page) . '</a>' : '')
    . '</p>'
    . '<p><strong>Submitted Page URL:</strong> '
    . ($page_url ? '<a href="' . esc_url($page_url) . '" target="_blank">' . esc_html($page_url) . '</a>' : '')
    . '</p>';
```

如果你原本已经有 `Page URL` 字段，也可以改名为 `Submitted Page URL`，这样更清楚。

---

## 推荐邮件字段结构

建议邮件中至少保留这些信息：

```txt
Name
Email
Phone
State
Subject
Message

IP Address
Facebook Ads
First Landing Page
Facebook Ads Landing Page
Submitted Page URL
Submitted At
```

含义说明：

| 字段 | 含义 |
|---|---|
| Facebook Ads | 是否来自 Facebook 广告 |
| First Landing Page | 用户第一次进入网站的页面 |
| Facebook Ads Landing Page | 带有 `fb_ads=1` 的广告落地页 |
| Submitted Page URL | 用户最终提交表单的页面 |
| IP Address | 用户 IP |
| Submitted At | 提交时间 |

---

## 测试方法

### 测试 1：直接在 Contact 页面提交

访问：

```txt
https://www.example.com/contact-us/?fb_ads=1
```

提交表单后，邮件中应该显示：

```txt
Facebook Ads: Yes
First Landing Page: https://www.example.com/contact-us/?fb_ads=1
Facebook Ads Landing Page: https://www.example.com/contact-us/?fb_ads=1
Submitted Page URL: https://www.example.com/contact-us/?fb_ads=1
```

---

### 测试 2：先进入产品页，再进入 Contact 页面

访问：

```txt
https://www.example.com/product-page/?fb_ads=1
```

然后手动点击进入：

```txt
https://www.example.com/contact-us/
```

提交表单后，邮件中应该显示：

```txt
Facebook Ads: Yes
First Landing Page: https://www.example.com/product-page/?fb_ads=1
Facebook Ads Landing Page: https://www.example.com/product-page/?fb_ads=1
Submitted Page URL: https://www.example.com/contact-us/
```

---

### 测试 3：普通访问

访问：

```txt
https://www.example.com/contact-us/
```

提交表单后，邮件中应该显示：

```txt
Facebook Ads: No
```

---

## 测试时的注意事项

因为本方案会使用浏览器的 `sessionStorage`，部分旧版本也可能使用 `localStorage`，测试时需要注意：

如果你已经访问过带有 `fb_ads=1` 的链接，当前浏览器会一直记住 `Facebook Ads: Yes`。

重新测试普通流量时，可以：

1. 使用无痕窗口测试
2. 或者清除浏览器缓存 / localStorage
3. 或者在浏览器控制台执行：

```js
localStorage.removeItem('facebook_ads');
localStorage.removeItem('first_landing_page');
localStorage.removeItem('fb_ads_landing_page');

// 如果你的项目使用 sessionStorage，则执行：
sessionStorage.removeItem('facebook_ads');
sessionStorage.removeItem('first_landing_page');
sessionStorage.removeItem('fb_ads_landing_page');
```

---

## 常见问题

### 1. 只用 `fb_ads=1`，不用 UTM，可以吗？

可以。

如果只是为了在邮箱里判断是否来自 Facebook 广告，`fb_ads=1` 已经足够。

---

### 2. 这个能区分具体广告系列、广告组、广告名称吗？

不能。

这个方案只判断：

```txt
是不是 Facebook 广告来的
```

如果后期需要区分广告系列、广告组、广告名称，可以升级为 UTM 方案，例如：

```txt
utm_source=facebook&utm_medium=paid_social&utm_campaign=xxx&utm_content=xxx
```

---

### 3. 用户跳转多个页面后还能识别吗？

可以。

因为广告标记会保存到 `sessionStorage`，复杂表单还可以通过 PHP Session 做服务器端兜底。

只要用户使用同一个浏览器，在没有清除浏览器数据的情况下，后续进入 Contact 页面提交表单，仍然可以识别。

---

### 4. 用户换浏览器或换设备后还能识别吗？

不能。

`sessionStorage` / `localStorage` 只保存在当前浏览器和当前设备中。

---

### 5. 这个能替代 Meta Pixel 吗？

不能完全替代。

这个方案主要用于在询盘邮件中标记来源，方便人工查看。

Meta Pixel 更适合做广告后台转化归因、再营销和广告优化。

---

## 后期添加到其他网站的步骤

1. 在 Facebook / Meta 广告链接中添加：

```txt
fb_ads=1
```

2. 在目标 WordPress 主题的 `functions.php` 中加入全站追踪脚本。

3. 在表单页面加入 3 个隐藏字段：

```html
<input type="hidden" name="facebook_ads" id="facebook_ads" value="No">
<input type="hidden" name="first_landing_page" id="first_landing_page">
<input type="hidden" name="fb_ads_landing_page" id="fb_ads_landing_page">
```

4. 确认 Ajax 提交时包含：

```js
formData.push({ name: 'page_url', value: window.location.href });
```

5. 在 PHP 邮件函数中接收字段。

6. 在邮件正文中输出：

```txt
Facebook Ads
First Landing Page
Facebook Ads Landing Page
Submitted Page URL
```

7. 如果表单使用独立 JS 且手动 `new FormData()`，记得把 `facebook_ads`、`first_landing_page`、`fb_ads_landing_page` 手动 `append()` 进去。
8. 修改独立 JS 后，更新版本号，例如 `?v=1.0.4`，或使用 `filemtime()` 自动刷新版本。
9. 使用无痕窗口进行测试。


---

## 最终检查清单

把这套方案复用到其他网站时，建议逐项检查：

1. Facebook / Meta 广告链接是否带有 `fb_ads=1`。
2. 主题是否已经启用 PHP Session。
3. `functions.php` 是否有服务器端兜底记录逻辑。
4. 全站 `wp_footer` 脚本是否能正常输出。
5. 表单隐藏字段是否存在，或者是否能自动注入。
6. 所有邮件正文是否调用统一的 Facebook Ads 邮件输出函数。
7. 普通 Ajax 表单是否使用 `serializeArray()` 或 `FormData(form)`。
8. 手动 `new FormData()` 的表单是否手动 append 了 3 个字段。
9. 独立 JS 更新后，是否修改版本号或使用 `filemtime()`。
10. 是否用无痕窗口分别测试广告流量和普通流量。

---

## 安全提醒

如果你的 `functions.php` 中包含 SMTP 邮箱、授权码、API Key 等敏感信息，不要上传到公开 GitHub 仓库。

公开示例代码时建议替换成占位符：

```php
$phpmailer->Username = 'your-email@example.com';
$phpmailer->Password = 'your-smtp-app-password';
```

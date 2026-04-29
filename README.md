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

当用户访问带有 `fb_ads=1` 的页面时，前端 JavaScript 会把来源信息保存到浏览器的 `localStorage` 中。

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

因为本方案使用了浏览器的 `localStorage`，测试时需要注意：

如果你已经访问过带有 `fb_ads=1` 的链接，当前浏览器会一直记住 `Facebook Ads: Yes`。

重新测试普通流量时，可以：

1. 使用无痕窗口测试
2. 或者清除浏览器缓存 / localStorage
3. 或者在浏览器控制台执行：

```js
localStorage.removeItem('facebook_ads');
localStorage.removeItem('first_landing_page');
localStorage.removeItem('fb_ads_landing_page');
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

因为广告标记会保存到 `localStorage`。

只要用户使用同一个浏览器，在没有清除浏览器数据的情况下，后续进入 Contact 页面提交表单，仍然可以识别。

---

### 4. 用户换浏览器或换设备后还能识别吗？

不能。

`localStorage` 只保存在当前浏览器和当前设备中。

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

7. 使用无痕窗口进行测试。

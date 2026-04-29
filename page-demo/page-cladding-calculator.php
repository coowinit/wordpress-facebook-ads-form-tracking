<section id="dcbox">
    <div class="container text-center my-5">
        <h2>Composite Cladding Type</h2>
        <p>Which type of cladding board do you want? Please select from the following options.</p>

        <div class="row justify-content-center">
            <!-- 可点击的卡片 -->
            <div class="col-6 col-md-3">
                <div class="decking-card active" data-width="219">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/c01-CPF-03.webp' ) ); ?>" class="mx-auto d-block" alt="CPF-03">
                    <span>CPF-03(219*26mm)</span>
                    <!-- 产品（主材）默认的斜面大小，其中219mm（宽度）是需要参与计算的（为了计算后面的配件使用），26mm(厚度)不需要计算，以下都是 -->
                </div>
            </div>

            <!-- 暂时禁用的卡片，不参与计算 -->
            <div class="col-6 col-md-2 d-none">  <!-- d-none 是在所有设备都隐藏 -->
                <div class="decking-card disabled" data-width="157">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/c02-CPC-01.webp' ) ); ?>" alt="CPC-01">
                    <span>CPC-01(157*21mm)</span>
                </div>
            </div>

            <div class="col-6 col-md-2 d-none">
                <div class="decking-card disabled" data-width="220">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/c03-CPC-02.webp' ) ); ?>" alt="CPC-02">
                    <span>CPC-02(220*19mm)</span>
                </div>
            </div>

            <div class="col-6 col-md-2 d-none">
                <div class="decking-card disabled" data-width="242">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/c04-CPF-01.webp' ) ); ?>" alt="CPF-01">
                    <span>CPF-01(242*33mm)</span>
                </div>
            </div>

            <div class="col-6 col-md-2 d-none">
                <div class="decking-card disabled" data-width="222">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/c05-CPF-04.webp' ) ); ?>" alt="CPF-04">
                    <span>CPF-04(222*23mm)</span>
                </div>
            </div>

            <div class="col-6 col-md-2 d-none">
                <div class="decking-card disabled" data-width="176">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/c06-CPF-06.webp' ) ); ?>" alt="CPF-06">
                    <span>CPF-06(176*26mm)</span>
                </div>
            </div>

            <!-- 第二行 -->
            <div class="col-6 col-md-2 d-none">
                <div class="decking-card disabled" data-width="234">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/c07-CPF-07.webp' ) ); ?>" alt="CPF-07">
                    <span>CPF-07(234*26mm)</span>
                </div>
            </div>

            <div class="col-6 col-md-2 d-none">
                <div class="decking-card disabled" data-width="73">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/c08-CPF-08A.webp' ) ); ?>" alt="CPF-08A">
                    <span>CPF-08A(73*30mm)</span>
                </div>
            </div>

            <div class="col-6 col-md-2 d-none">
                <div class="decking-card disabled" data-width="223">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/c09-CPF-08.webp' ) ); ?>" alt="CPF-08">
                    <span>CPF-08(223*19mm)</span>
                </div>
            </div>

            <div class="col-6 col-md-2 d-none">
                <div class="decking-card disabled" data-width="219">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/c10-CPF-09.webp' ) ); ?>" alt="CPF-09">
                    <span>CPF-09(219*26mm)</span>
                </div>
            </div>

            <div class="col-6 col-md-2 d-none">
                <div class="decking-card disabled" data-width="140">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/c11-EC-01.webp' ) ); ?>" alt="EC-01">
                    <span>EC-01(140*21mm)</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center my-5">
        <h2>Composite Cladding Length</h2>
        <p>Please select the length of the cladding board you need.</p>
        <div class="row justify-content-center">
            <div class="col-6 col-md-5 mb-3 mb-md-0">
                <div class="board-box active" data-length="5.4">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/cladding-length-5-4m.webp' ) ); ?>" alt="Board" class="board-img img-fluid">
                    <div class="board-length">5.4m</div>
                    <!-- 板子长度是单选，单击之后需要添加高亮类（active），默认是选中状态 -->
                </div>
            </div>
            <div class="col-6 col-md-5">
                <div class="board-box" data-length="2.9">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/cladding-length-2-9m.webp' ) ); ?>" alt="Board" class="board-img img-fluid">
                    <div class="board-length">2.9m</div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center my-5">
        <h2>Dimensions</h2>
        <p>Enter the cladding length and width to calculate the area, or enter the required quantity of deck boards.</p>
        <!-- 面积或者板材支数只能填写一项，不能同时填写 -->

        <form id="dimensionForm">
            <div class="dimension-helper col-12 col-lg-10 mx-auto">
                <div class="form-row align-items-center justify-content-center dimension-formula-row">
                    <div class="col-12 col-md-3 mb-3 mt-3">
                        <input type="number" class="dimension-input" id="lengthInput" min="0" step="0.01" inputmode="decimal" placeholder="Length (m)">
                    </div>

                    <div class="col-auto d-none d-md-flex align-items-center justify-content-center px-1">
                        <span class="dimension-operator">×</span>
                    </div>

                    <div class="col-12 col-md-3 mb-3 mt-3">
                        <input type="number" class="dimension-input" id="widthInput" min="0" step="0.01" inputmode="decimal" placeholder="Width (m)">
                    </div>

                    <div class="col-auto d-none d-md-flex align-items-center justify-content-center px-1">
                        <span class="dimension-operator">=</span>
                    </div>

                    <div class="col-12 col-md-4 mb-3 mt-3">
                        <input type="number" class="dimension-input" id="areaInput" min="0" step="0.01" inputmode="decimal" placeholder="Area (sqm)">
                    </div>
                </div>
            </div>

            <div class="form-row align-items-center justify-content-center">
                <div class="col-12 col-md-1 d-flex align-items-center justify-content-center mb-3">
                    <div class="or-divider">OR</div>
                </div>

                <div class="col-12 col-md-4 mb-3">
                    <input type="number" class="dimension-input" id="quantityInput" min="0" step="1" inputmode="numeric" placeholder="Quantity (pcs)">
                </div>
            </div>

            <button type="button" class="btn calculate-btn" id="calculateBtn">Calculate</button>
        </form>
    </div>

    <!-- 计算结果：整个HTML是不显示的，只有点击计算按钮计算后才会显示 -->
    <div class="container my-5" id="resultContainer" style="display:none;">
        <h3 class="text-center mb-4">You Will Need</h3>
    <div class="row">
    
        <!-- 每个 item-box 我给 input 加 data-code，方便脚本找到 -->
        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc01-CPF-03.webp' ) ); ?>" alt="CPF-03">
                <div class="item-info">
                    <span class="item-code">CPF-03</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="CPF-03" value="0">
                        <!-- 
                        墙板（Cladding）的计算公式：
                        如果选中长度是5.4m：
                            输入面积时：面积*0.848，并向上取整
                            输入支数时：支数*1，并向上取整
                        如果选中长度是2.9m：
                            输入面积时：面积*1.725，并向上取整
                            输入支数时：支数*1，并向上取整
                        -->
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc02-EA-21.webp' ) ); ?>" alt="EA-21">
                <div class="item-info">
                    <span class="item-code">EA-21</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="EA-21" value="0">
                        <!-- 
                        EA-21是金属色螺钉（Metal colored screw）的计算公式：
                        如果选中长度是5.4m：
                            输入面积时：面积*1，并向上取整
                            输入支数时：1/宽度*1000*长度*支数，并向上取整
                        如果选中长度是2.9m：
                            输入面积时：面积*1，并向上取整
                            输入支数时：1/宽度*1000*长度*支数，并向上取整
                        -->
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc03-EA-02.webp' ) ); ?>" alt="EA-02">
                <div class="item-info">
                    <span class="item-code">EA-02</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="EA-02" value="0">
                        <!-- 
                        封边L角（Capped L Corner）的计算公式：
                        如果选中长度是5.4m：
                            输入面积时：面积/2，并向上取整
                            输入支数时：(1/宽度*1000*长度*支数)/2，并向上取整
                        如果选中长度是2.9m：
                            输入面积时：面积/2，并向上取整
                            输入支数时：(1/宽度*1000*长度*支数)/2，并向上取整
                        -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc04-EA-22.webp' ) ); ?>" alt="EA-22">
                <div class="item-info">
                    <span class="item-code">EA-22</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="EA-22" value="0">
                        <!-- 
                        封边侧板（Capped Side Panel）的计算公式：
                        如果选中长度是5.4m：
                            输入面积时：面积/2，并向上取整
                            输入支数时：(1/宽度*1000*长度*支数)/2，并向上取整
                        如果选中长度是2.9m：
                            输入面积时：面积/2，并向上取整
                            输入支数时：(1/宽度*1000*长度*支数)/2，并向上取整
                        -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc05-EA-04.webp' ) ); ?>" alt="EA-04">
                <div class="item-info">
                    <span class="item-code">EA-04</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="EA-04" value="0">
                        <!-- 
                        铝合金龙骨（Alunimium cladding joist）的计算公式：
                        如果选中长度是5.4m：
                            输入面积时：面积*4，并向上取整
                            输入支数时：(1/宽度*1000/长度*支数)*4，并向上取整
                        如果选中长度是2.9m：
                            输入面积时：面积*4，并向上取整
                            输入支数时：(1/宽度*1000/长度*支数)*4，并向上取整
                        -->
                    </div>
                </div>
            </div>
        </div>
    
    </div>
    
    <!-- 描述文字 -->
    <p class="note-text mt-3">
        <span>*</span> Please note that the calculation includes a 5% allowance for material waste to prevent shortages during installation.
    </p>

    <!-- 按钮 -->
    <div class="text-center mt-4">
        <button type="button" class="btn btn-custom" data-toggle="modal" data-target="#emailModal">
        Send the List to Email
        </button>
    </div>

    <!-- Bootstrap 模态框 -->
    <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form id="emailForm" class="modal-content">
                <?php wp_nonce_field('calc_email_nonce', 'calc_email_nonce'); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="emailModalLabel">Send the List to Email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Name *" required="">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email *" required="">
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" class="form-control" placeholder="Phone">
                    </div>
                    <div class="form-group">
                        <select name="state" class="form-control" required>
                            <?php echo evodek_render_state_options(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="message" class="form-control" rows="3" placeholder="Please enter your requirements."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-custom">Send</button>
                </div>
            </form>
        </div>
    </div>


    </div>
    <!-- 计算结果 End -->
</section>  

<script>
// 在 jQuery(document).ready(function($){ ... }) 的函数作用域内，可以放心使用 $，不需要写 jQuery
jQuery(document).ready(function($){

    var $lengthInput = $('#lengthInput');
    var $widthInput = $('#widthInput');
    var $areaInput = $('#areaInput');
    var $quantityInput = $('#quantityInput');
    var $calculateBtn = $('#calculateBtn');
    var $resultContainer = $('#resultContainer');

    // 型号对应英文名称映射表
    var productNames = {
        "CPF-03": "Cladding board",
        "EA-21": "Metal colored screw",
        "EA-02": "Capped L Corner",
        "EA-22": "Capped Side Panel",
        "EA-04": "Aluminium cladding joist"
    };

    function hasValue($el){
        return ($el.val() || '').trim() !== '';
    }

    function getNumber($el){
        return parseFloat(($el.val() || '').trim());
    }

    function formatArea(val){
        return Number(val.toFixed(2)).toString();
    }

    function syncInputState(){
        var useAreaMode = hasValue($lengthInput) || hasValue($widthInput) || hasValue($areaInput);
        var useQtyMode = hasValue($quantityInput);

        $quantityInput.prop('disabled', useAreaMode);
        $lengthInput.prop('disabled', useQtyMode);
        $widthInput.prop('disabled', useQtyMode);
        $areaInput.prop('disabled', useQtyMode);
    }

    function updateAreaFromDimensions(){
        var lengthValue = getNumber($lengthInput);
        var widthValue = getNumber($widthInput);

        if(!isNaN(lengthValue) && lengthValue > 0 && !isNaN(widthValue) && widthValue > 0){
            $areaInput.val(formatArea(lengthValue * widthValue));
        } else if(!hasValue($lengthInput) && !hasValue($widthInput)) {
            // 两个尺寸都清空时，保留手动输入面积的能力
        } else {
            $areaInput.val('');
        }

        syncInputState();
    }

    $lengthInput.on('input', updateAreaFromDimensions);
    $widthInput.on('input', updateAreaFromDimensions);
    $areaInput.on('input', function(){
        syncInputState();
    });
    $quantityInput.on('input', function(){
        syncInputState();
    });

    syncInputState();

    // 切换长度
    $('.board-box').on('click', function(){
        $('.board-box').removeClass('active');
        $(this).addClass('active');
    });

    // 切换主材
    $('.decking-card').on('click', function(){
        if($(this).hasClass('disabled')) return;
        $('.decking-card').removeClass('active');
        $(this).addClass('active');
    });

    // 工具函数
    function ceil(v){ return Math.ceil(v); }

    // 设置数量并显示英文名称
    function setItemQty(code, val){
        var $input = $('input[data-code="'+code+'"]');
        if($input.length){
            $input.val(val);
            var $span = $input.closest('.item-info').find('.item-code');
            if($span.length && productNames[code]){
                $span.text(code + ' - ' + productNames[code]);
            }
        }
    }

    // 计算按钮
    $calculateBtn.on('click', function(){
        var area = parseFloat($areaInput.val().trim());
        var qty = parseFloat($quantityInput.val().trim());
        var inputLength = getNumber($lengthInput);
        var inputWidth = getNumber($widthInput);

        if(isNaN(area) && !isNaN(inputLength) && inputLength > 0 && !isNaN(inputWidth) && inputWidth > 0){
            area = inputLength * inputWidth;
            $areaInput.val(formatArea(area));
        }
        var length = parseFloat($('.board-box.active').data('length'));
        var width = parseFloat($('.decking-card.active').data('width'));

        if(isNaN(area) && isNaN(qty)){
            alert("Please enter area or quantity");
            return;
        }

        // === 面积模式 ===
        if(!isNaN(area)){
            if(length === 5.4){
                setItemQty("CPF-03", ceil(area * (0.848 + 0.05))); // 主材加上了 5% 的损耗
                setItemQty("EA-21", ceil(area * 1));
                setItemQty("EA-02", ceil(area / 2));
                setItemQty("EA-22", ceil(area / 2));
                setItemQty("EA-04", ceil(area * 4));
            } else {
                setItemQty("CPF-03", ceil(area * 1.725));
                setItemQty("EA-21", ceil(area * 1));
                setItemQty("EA-02", ceil(area / 2));
                setItemQty("EA-22", ceil(area / 2));
                setItemQty("EA-04", ceil(area * 4));
            }
        }

        // === 支数模式 ===
        if(!isNaN(qty)){
            if(length === 5.4){
                setItemQty("CPF-03", ceil(qty * 1.05));  // 主材加上了 5% 的损耗
                setItemQty("EA-21", ceil((1000 / width) * length * qty));
                setItemQty("EA-02", ceil(((1000 / width) * length * qty) / 2));
                setItemQty("EA-22", ceil(((1000 / width) * length * qty) / 2));
                setItemQty("EA-04", ceil(((1000 / width) * qty) / length * 4));
            } else {
                setItemQty("CPF-03", ceil(qty * 1.05));  // 主材加上了 5% 的损耗
                setItemQty("EA-21", ceil((1000 / width) * length * qty));
                setItemQty("EA-02", ceil(((1000 / width) * length * qty) / 2));
                setItemQty("EA-22", ceil(((1000 / width) * length * qty) / 2));
                setItemQty("EA-04", ceil(((1000 / width) * qty) / length * 4));
            }
        }

        $resultContainer.show();
    });

    // 收集计算结果 + Ajax 提交
    $('#emailForm').on('submit', function(e){
        e.preventDefault();

        // 1. 收集计算结果
        var items = [];
        $('#resultContainer .item-box').each(function(){
            var code = $(this).find('.item-code').text().trim();
            var qty = $(this).find('input').val().trim();
            items.push(code + ": " + qty);
        });

        // 2. 收集用户填写
        var formData = new FormData(this);
        formData.append("action", "send_calc_email"); // WP ajax action
        formData.append("items", items.join("\n"));
        formData.append("calc_type", "Cladding Calculator"); // 标识墙板计算器
        formData.append("page_url", window.location.href);
        formData.append("user_agent", navigator.userAgent);

        // 3. 发送 Ajax
        $.ajax({
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                if(response.success){
                    alert("Email sent successfully!");
                    $('#emailModal').modal('hide');
                    $('#emailForm')[0].reset();
                } else {
                    var failMsg = (response && response.data) ? (typeof response.data === "string" ? response.data : (response.data.msg || JSON.stringify(response.data))) : "Failed to send email";
                    alert("Failed: " + failMsg);
                }
            },
            error: function(xhr){
                var errorMsg = "Request failed, please try again.";
                if (xhr && xhr.responseJSON && xhr.responseJSON.data) {
                    errorMsg = typeof xhr.responseJSON.data === "string" ? xhr.responseJSON.data : (xhr.responseJSON.data.msg || JSON.stringify(xhr.responseJSON.data));
                } else if (xhr && xhr.responseText) {
                    errorMsg = xhr.responseText === "-1" ? "Security verification failed, please refresh the page and try again." : xhr.responseText;
                }
                alert(errorMsg);
            }
        });
    });

});
</script>
<section id="dcbox">
    <div class="container text-center my-5">
        <h2>Composite Deck Type</h2>
        <p>Which type of deck board do you want? Please select from the following options.</p>

        <div class="row justify-content-center">
        <!-- 可点击的卡片 -->
            <div class="col-6 col-md-3">
                <div class="decking-card active">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/p01-CPD-05.webp' ) ); ?>" class="mx-auto d-block" alt="CPD-05">
                <span>CPD-05(138*23mm)</span>
                <!-- 产品（主材）默认的斜面大小，其中138mm（宽度）是需要参与计算的（为了计算后面的配件使用），23mm（厚度）是不参与计算的，以下都是 -->
            </div>
        </div>

        <!-- 暂时禁用的卡片，不参与计算 -->
        <div class="col-6 col-md-2 d-none">  <!-- d-none 是在所有设备都隐藏 -->
            <div class="decking-card disabled">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/p02-CPD-03.webp' ) ); ?>" alt="CPD-03">
                <span>CPD-03(138*23mm)</span>
            </div>
        </div>

        <div class="col-6 col-md-2 d-none">
            <div class="decking-card disabled">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/p03-CPD-04.webp' ) ); ?>" alt="CPD-04">
                <span>CPD-04(138*23mm)</span>
            </div>
        </div>

        <div class="col-6 col-md-2 d-none">
            <div class="decking-card disabled">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/p04-CPD-06.webp' ) ); ?>" alt="CPD-06">
                <span>CPD-06(138*23mm)</span>
            </div>
        </div>

        <div class="col-6 col-md-2 d-none">
            <div class="decking-card disabled">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/p05-CPD-07.webp' ) ); ?>" alt="CPD-07">
                <span>CPD-07(140*23mm)</span>
            </div>
        </div>

        <div class="col-6 col-md-2 d-none">
            <div class="decking-card disabled">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/p06-CPD-08.webp' ) ); ?>" alt="CPD-08">
                <span>CPD-08(138*23mm)</span>
            </div>
        </div>

        <!-- 第二行 -->
        <div class="col-6 col-md-2 d-none">
            <div class="decking-card disabled">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/p07-CPD-09.webp' ) ); ?>" alt="CPD-09">
                <span>CPD-09(135*23mm)</span>
            </div>
        </div>

        <div class="col-6 col-md-2 d-none">
            <div class="decking-card disabled">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/p08-CPD-10.webp' ) ); ?>" alt="CPD-10">
                <span>CPD-10(144*23mm)</span>
            </div>
        </div>

        <div class="col-6 col-md-2 d-none">
            <div class="decking-card disabled">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/p09-ED-01.webp' ) ); ?>" alt="ED-01">
                <span>ED-01(150*25mm)</span>
            </div>
        </div>

        <div class="col-6 col-md-2 d-none">
            <div class="decking-card disabled">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/p10-ED-02.webp' ) ); ?>" alt="ED-02">
                <span>ED-02(150*25mm)</span>
            </div>
        </div>

        <div class="col-6 col-md-2 d-none">
            <div class="decking-card disabled">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/p11-ED-03.webp' ) ); ?>" alt="ED-03">
                <span>ED-03(138*23mm)</span>
            </div>
        </div>
        </div>
    </div>

    <div class="container text-center my-5">
        <h2>Composite Deck Length</h2>
        <p>Please select the length of the deck board you need.</p>
        <div class="row justify-content-center">
            <div class="col-12 col-md-5">
                <div class="board-box active">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/decking-length-5-4m.webp' ) ); ?>" alt="Decking Board" class="board-img img-fluid">
                    <div class="board-length">5.4m</div>
                    <!-- 板子长度就这一种，默认是选中状态的 -->
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center my-5">
        <h2>Dimensions</h2>
        <p>Enter the deck length and width to calculate the area, or enter the required quantity of deck boards.</p>
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
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc01-CPD-05.webp' ) ); ?>" alt="CPD-05">
                <div class="item-info">
                    <span class="item-code">CPD-05</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="CPD-05" value="30">
                        <!-- 
                            地板（Decking）的计算公式：
                            输入面积时：面积*1.325，并向上取整
                            输入支数时：支数*1
                        -->
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc02-CPST-01.webp' ) ); ?>" alt="CPST-01">
                <div class="item-info">
                    <span class="item-code">CPST-01</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="CPST-01" value="30">
                        <!-- 
                            起始板（Start board）的计算公式：
                            输入面积时：面积*1
                            输入支数时：长度*支数/(1/宽度*1000)，并向上取整
                        -->
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc03-CPFA-02.webp' ) ); ?>" alt="CPFA-02">
                <div class="item-info">
                    <span class="item-code">CPFA-02</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="CPFA-02" value="30">
                        <!-- 
                            收边板（Fascia baord）的计算公式：
                            输入面积时：面积*1
                            输入支数时：长度*支数/(1/宽度*1000)，并向上取整
                        -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc04-EA-03.webp' ) ); ?>" alt="EA-03">
                <div class="item-info">
                    <span class="item-code">EA-03</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="EA-03" value="30">
                        <!-- 
                            实心龙骨（Solid joist）的计算公式：
                            输入面积时：面积*4
                            输入支数时：(长度*支数)/(1/宽度*1000)*4，并向上取整
                        -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc05-EA-16-24.webp' ) ); ?>" alt="EA-16-24">
                <div class="item-info">
                    <span class="item-code">EA-16/24</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="EA-16/24" value="30">
                        <!-- 
                            隐藏式卡扣（Hidden Fastener）的计算公式：
                            输入面积时：1000/(宽度+5)*3.5，并向上取整
                            输入支数时：((长度*支数)/(1/宽度*1000))*24，并向上取整
                        -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc06-EA-06.webp' ) ); ?>" alt="EA-06">
                <div class="item-info">
                    <span class="item-code">EA-06</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="EA-06" value="30">
                        <!-- 
                            起始卡扣（Start clip）的计算公式：
                            输入面积时：面积*1
                            输入支数时：长度*支数/(1/(宽度+5)*1000)，并向上取整
                        -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc07-EA-18.webp' ) ); ?>" alt="EA-18">
                <div class="item-info">
                    <span class="item-code">EA-18</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="EA-18" value="30">
                        <!-- 
                            锁扣（Locking clip）的计算公式：
                            输入面积时：面积*1
                            输入支数时：长度*支数/(1/(宽度+5)*1000)，并向上取整
                        -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc08-Bit-kit.webp' ) ); ?>" alt="Bit kit">
                <div class="item-info">
                    <span class="item-code">Bit kit</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="Bit kit" value="/">
                        <!-- 螺丝&钻头套件（Screw kit & Drill kit）不参与计算，保留默认的斜杠即可 -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc09-EA-10.webp' ) ); ?>" alt="EA-10">
                <div class="item-info">
                    <span class="item-code">EA-10</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="EA-10" value="30">
                        <!-- 
                            木螺钉（Timber screw）的计算公式：
                            输入面积时：(1000/(宽度+5)*3.5)+面积*1，并向上取整
                            输入支数时：((长度*支数)/(1/宽度*1000))*24+长度*支数/(1/(宽度+5)*1000)，并向上取整
                        -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc010-EA-11.webp' ) ); ?>" alt="EA-11">
                <div class="item-info">
                    <span class="item-code">EA-11</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="EA-11" value="30">
                        <!-- 
                            木色螺钉（Timber colored screw）计算公式：
                            输入面积时：面积*1
                            输入支数时：长度*支数/(1/(宽度+5)*1000)，并向上取整
                        -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="item-box">
                <img src="<?php echo esc_url( get_theme_file_uri( 'images/calculator/new/calc011-EA-13.webp' ) ); ?>" alt="EA-13">
                <div class="item-info">
                    <span class="item-code">EA-13</span>
                    <div class="item-qty">
                        <input type="text" class="form-control" data-code="EA-13" value="30">
                        <!-- 
                            金属螺钉（Metal screw）的计算公式：
                            输入面积时：(1000/(宽度+5)*3.5)+面积*1，并向上取整
                            输入支数时：((长度*支数)/(1/宽度*1000))*24+长度*支数/(1/(宽度+5)*1000)，并向上取整
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
            <button type="button" class="btn btn-custom" data-toggle="modal" data-target="#emailModal">Send the List to Email</button>
        </div>

        <!-- Bootstrap 模态框 -->
        <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form id="emailForm" class="modal-content">
                    <?php wp_nonce_field('calc_email_nonce', 'calc_email_nonce'); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="emailModalLabel">Send the List to Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span></button>
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

    var boardLength = 5.4; // 米
    var boardWidth = 138;  // mm

    // 型号对应英文名称映射表
    var productNames = {
        "CPD-05": "Decking board",
        "CPST-01": "Start board",
        "CPFA-02": "Fascia board",
        "EA-03": "Solid joist",
        "EA-16/24": "Hidden Fastener",
        "EA-06": "Start clip",
        "EA-18": "Locking clip",
        "Bit kit": "Screw kit & Drill kit",
        "EA-10": "Timber screw",
        "EA-11": "Timber colored screw",
        "EA-13": "Metal screw"
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

        if(!isNaN(area)){
            // 面积计算
            setItemQty("CPD-05", ceil(area * (1.325 + 0.05)));
            setItemQty("CPST-01", ceil(area * 1));
            setItemQty("CPFA-02", ceil(area * 1));
            setItemQty("EA-03", ceil(area * 4));
            setItemQty("EA-16/24", ceil((1000 / (boardWidth + 5)) * 3.5));
            setItemQty("EA-06", ceil(area * 1));
            setItemQty("EA-18", ceil(area * 1));
            setItemQty("EA-10", ceil((1000 / (boardWidth + 5)) * 3.5 + area * 1));
            setItemQty("EA-11", ceil(area * 1));
            setItemQty("EA-13", ceil((1000 / (boardWidth + 5)) * 3.5 + area * 1));
            setItemQty("Bit kit", "/");
        } else if(!isNaN(qty)){
            // 数量计算
            var base = (boardLength * qty) / (1 / boardWidth * 1000);
            var base2 = (boardLength * qty) / (1 / (boardWidth + 5) * 1000);

            setItemQty("CPD-05", ceil(qty * 1.05));
            setItemQty("CPST-01", ceil(base));
            setItemQty("CPFA-02", ceil(base));
            setItemQty("EA-03", ceil(base * 4));
            setItemQty("EA-16/24", ceil(base * 24));
            setItemQty("EA-06", ceil(base2));
            setItemQty("EA-18", ceil(base2));
            setItemQty("EA-10", ceil(base * 24 + base2));
            setItemQty("EA-11", ceil(base2));
            setItemQty("EA-13", ceil(base * 24 + base2));
            setItemQty("Bit kit", "/");
        } else {
            alert("Please enter area or quantity");
            return;
        }

        $resultContainer.show();
    });

    // Ajax 提交
    $('#emailForm').on('submit', function(e){
        e.preventDefault();

        var items = [];
        $('#resultContainer .item-box').each(function(){
            var code = $(this).find('.item-code').text().trim();
            var qty = $(this).find('input').val().trim();
            items.push(code + ": " + qty);
        });

        var formData = new FormData(this);
        formData.append("action", "send_calc_email");
        formData.append("items", items.join("\n"));
        formData.append("calc_type", "Decking Calculator"); // 标识
        formData.append("page_url", window.location.href);
        formData.append("user_agent", navigator.userAgent);

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
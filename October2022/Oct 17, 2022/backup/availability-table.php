<section class="full-section accordion-sec">
    <div class="container">
        <div class="table-wrapper">
            <div class="table-head">
                <div class="head-col">Departure Date</div>
                <div class="head-col">Form Price</div>
                <div class="head-col">Status</div>
            </div>
            <div class="table-body">
                <?php 
                if( have_rows('availability_table') ):
                    $n = 0;
                    while( have_rows('availability_table') ) : the_row();
                        $price = get_sub_field('price')
                        ?>
                        <div class="accordion-set">
                            <div class="accordion-head">
                                <div class="col ac-date"><?php echo get_sub_field('date'); ?></div>
                                <input type="hidden" value="<?php echo get_sub_field('date'); ?>" class="date<?php echo $n ?>">
                                <div class="col ac-price"><?php echo _currency_format($price, true); ?></div>
                                <input type="hidden" value="<?php echo get_sub_field('price'); ?>" class="price<?php echo $n ?>">
                                <div class="col ac-avl"><?php echo $avl = get_sub_field('availability'); ?></div>
                                <input type="hidden" value="<?php if ($avl == 'Available') echo 1; elseif ($avl == 'Limited Cabins') echo 2; elseif ($avl == 'Sold Out') echo 3; ?>" class="avl<?php echo $n ?>">
                            </div>
                            <div class="accordion-body">
                                <div class="accordion_cover">
                                    <div class="cabines-area styler">
                                        <label for="<?php echo $n; ?>">Select Cabin</label>
                                        <select class="cabin-select" id="<?php echo $n; ?>">
                                            <option>No of Cabins</option>
                                            <!-- loop for cabins -->
                                            <?php for ($i=1; $i < 11 ; $i++) { ?>
                                                <!-- cabin option value -->
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="passenger-area styler">
                                        <label for="<?php echo $n; ?>">Select Passenger</label>
                                        <select class="passenger-select" id="<?php echo $n; ?>">
                                            <option>No of Passengers</option>
                                            <!-- loop for passengers -->
                                            <?php for ($i=1; $i < 21 ; $i++) { ?>
                                                <!-- passenger potion value -->
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="booking-btn styler"><a class="btn btn-green" href="javascript:;">Check Availability & Book</a></div>
                                </div>
                            </div>
                        </div>
                            <?php
                            $n++;
                        endwhile;
        // No value.
                    else :
                        echo 'Sorry! No details matching your repeater was found.<br>';
                    endif;
                    ?>
            </div>
        </div>
    </div>
</section>
<?php
add_action('wp_footer', 'jscode_avaibility');
function jscode_avaibility() {
    ?>
    <script>
        jQuery(function($) {

        function setUfgStorage(obj) {
            localStorage.setItem('UFGStorage', JSON.stringify(obj))
        }

        function getUfgStorage() {
            let x = JSON.parse( localStorage.getItem('UFGStorage') )
            if( x == null ) {
                x = {post_id: <?= get_the_ID(); ?>}
                console.log('x: '+setUfgStorage(x));
            }
            return x
        }

        let UFGStorage = getUfgStorage();

        // if (UFGStorage['date']) {
        //     window.location.href = 'https://staging8.cruisecroatia.com/inquire-form/';
        //     alert('this step has been completed');
        // }

        $('.booking-btn a').click(function(){
            if($(this).closest('.accordion-body').find('.cabin-select').val() > 0 && $(this).closest('.accordion-body').find('.passenger-select').val() > 0 ) {

                if ($(".passengers").length){
                    $(".passengers").attr("class", "full-section passengers pactive");
                    var num = 0;
                    if (UFGStorage['extensions']) {
                        var ufext = UFGStorage['extensions'];
                        $.each( ufext, function( key, value ) {
                            var all = $(".select_btn").map(function() {
                                if ($(this).attr("data-num") == value["num"]){
                                    $(this).addClass("active");
                                    $(this).text('Remove this Extension');
                                }
                            }).get();
                        });
                    }
                } else
                console.log('class not found');
            }
            else {
            }


        });

        //popup close
        $(document).on('click', '.pop_close', function(){
            $('.passengers').removeClass('pactive'); 
        });
        //popup close
        
        //add extension
        let ufgExtension = {}
        $('.select_btn').click(function() {

            if( $(this).hasClass("active") ) {
                console.log('remove')
                $(this).removeClass("active");
                $(this).text('Add this Extension');
                var exid = $(this).attr("data-id");
                var num = $(this).attr("data-num");
                if ( ufgExtension[exid] != undefined ) {
                    delete ufgExtension[exid]
                }
                
            } 
            else {
                $(this).addClass("active");
                $(this).text('Remove this Extension');
                var exid = $(this).attr("data-id");
                var num = $(this).attr("data-num");
                ufgExtension[exid] = { 'pid': exid, 'num': num }

            }
            console.log(ufgExtension)
            UFGStorage['extensions'] = ufgExtension
            setUfgStorage(UFGStorage)
            
        });
        
        //add extension
        
        let faqs = $(".accordion-body");
        $(".accordion-head").click(function () {
            faqs.slideUp();
            if( $(this).hasClass("active") ) {
                $(this).removeClass("active");
                $(this).next().slideUp();
            }
            else {
                faqs.prev().removeClass("active");
                $(this).next().slideDown();
                $(this).addClass("active");
            }
            return false;
        });
        
        $(".cabin-select").change(function(){
            var cid = $(this).attr('id');
            var date = $(".date"+cid).val();
            var price = $(".price"+cid).val();
            var avl = $(".avl"+cid).val();
            UFGStorage['date'] = date;
            UFGStorage['price'] = price;
            UFGStorage['avl'] = avl;
            UFGStorage['cabin'] = $(this).val();
            setUfgStorage(UFGStorage)
        });
        $(".passenger-select").change(function(){
            UFGStorage['passenger'] = $(this).val()
            setUfgStorage(UFGStorage)
            // localStorage.setItem('passenger', $(this).val());
        });
        
        $(".btn-nxt").click(function(){

        });

        for (let i = 0; i < 4; i++) {
            var id = 36
            if ( UFGStorage['ext_' + i] ) {
                $("#input_20_"+id).val( UFGStorage['ext_' + i] );
                id++
                $("#input_20_"+id).val( UFGStorage['ext_' + i] );
                id++
            }
            
        }

        console.log(UFGStorage)
        setUfgStorage(UFGStorage)

    });
</script>
<?php
}

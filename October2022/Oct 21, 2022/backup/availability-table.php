<section class="full-section accordion-sec">
    <div class="container">
        <div class="table-wrapper">
            <div class="table-head">
                <div class="head-col">Departure Date</div>
                <div class="head-col">From Price</div>
                <div class="head-col">Status</div>
            </div>
            <div class="table-body">
                <?php
                if( get_query_var('page') ) {
                    $page = get_query_var( 'page' );
                } else {
                    $page = 1;
                }                       
                $row = 0;
                $issues_per_page = 10; // How many images to display on each page
                $issues = get_field('availability_table');
                $total = count( $issues );
                $pages = ceil( $total / $issues_per_page );
                $min = ( ( $page * $issues_per_page ) - $issues_per_page ) + 1;
                $max = ( $min + $issues_per_page ) - 1;
                if( have_rows('availability_table') ):
                    $n = 0;
                    $ship_id = '274967';
                    while( have_rows('availability_table') ) : the_row();
                        $row++;
                        if($row < $min) {
                            continue;
                        } if($row > $max) {
                            break;
                        }
                        $price = get_sub_field('price');
                        ?>
                        <div class="accordion-set">
                            <?php $avl = get_sub_field('availability');
                            if ($avl == 'Sold Out') 
                                echo '<div class="accordion-head disabled">';
                            else 
                                echo '<div class="accordion-head">';?>
                            <div class="col ac-date"><?php echo get_sub_field('date'); ?></div>
                            <input type="hidden" value="<?php echo get_sub_field('date'); ?>" class="date<?php echo $n ?>">

                            <?php
                            $featured_post = get_field('ship');
                            print_r($featured_post);
                            die();
                            if( $featured_post ): ?>
                                        <div class="col ac-ship"><?php echo esc_html( $featured_post->post_title ); ?></div>
                                        <input type="hidden" value="<?php echo esc_html( $featured_post->post_title ); ?>" class="ship<?php echo $n ?>">
                               
<?php endif; ?>


                            <div class="col ac-price"><?php echo _currency_format($price, true); ?></div>
                            <input type="hidden" value="<?php echo get_sub_field('price'); ?>" class="price<?php echo $n ?>">
                            <div class="col ac-avl"><?php echo $avl; ?></div>
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
                                    <span class="text-danger cab-val"></span>
                                </div>
                                <div class="passenger-area styler">
                                    <label for="<?php echo $n; ?>">Select Passenger</label>
                                    <select class="passenger-select" id="<?php echo $n; ?>">
                                        <option>No of Passengers</option>
                                    </select>
                                    <span class="text-danger pass-val"></span>
                                </div>
                                <div class="booking-btn styler"><a class="btn btn-green" href="javascript:;">Check Availability & Book</a></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $n++;
                endwhile;
                ?>
                <script>
                    var availability_table_field_post_id = <?php echo get_the_ID(); ?>;
                    var availability_table_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
                </script>
                <?php
        // No value.
            else :
                echo 'Sorry! No details matching your repeater was found.<br>';
            endif;
            ?>
            <a id="availability_table_show_more_link" href="javascript: availability_table_show_more();"<?php 
            if ($total < $issues_per_page) {
                ?> style="display: none;"<?php 
            }
        ?>>Show More</a>
    </div>
</div>
</div>
</section>
<script>

    function availability_table_show_more() {

                    // make ajax request
                    jQuery.ajax({
                        url: availability_table_ajax_url,
                        type : "post",
                        data: {
                                    // this is the AJAX action we set up in PHP
                                    'action': 'availability_table_data',
                                    'post_id': availability_table_field_post_id,
                                },
                                success: function(resp) {
                                    let ajData = jQuery('.ajax-data', resp);
                                    console.log(ajData);

                                    jQuery('.table-body').append(resp);
                                    // see if there is more, if not then hide the more link

                                        // this ID must match the id of the show more link
                                        jQuery('#availability_table_show_more_link').css('display', 'none');
                                },
                                error: function(error) {
                                    console.log(error);
                                }
                            });

                }
            </script>
            <?php
            add_action('wp_footer', 'jscode_avaibility');
            function jscode_avaibility() {
                ?>
                <script>

                    jQuery(function($) {
                        localStorage.clear();
                        var availability_table_field_post_id = <?php echo get_the_ID(); ?>;
                        var availability_table_field_offset = 10;
                        var availability_table_field_nonce = '<?php echo wp_create_nonce('availability_table_field_nonce'); ?>';
                        var availability_table_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
                        var availability_table_more = true;


                        function setUfgStorage(obj) {
                            localStorage.setItem('UFGStorage', JSON.stringify(obj))
                        }

                        function getUfgStorage() {
                            let x = JSON.parse( localStorage.getItem('UFGStorage') )
                            if( x == null ) {
                                x = {post_id: <?= get_the_ID(); ?>}
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

                if ($(".passengers").length && $('.ex_style').length){

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
                } 
                else
                {
                    let blank = {};
                    UFGStorage['extensions'] = blank;
                    setUfgStorage(UFGStorage);
                    window.location.href = 'https://staging8.cruisecroatia.com/inquire-form/';
                }
            }

            else if(!($(this).closest('.accordion-body').find('.cabin-select').val() > 0) && !($(this).closest('.accordion-body').find('.passenger-select').val() > 0)) {
                //validation here
                $(this).closest('.accordion-body').find('.cab-val').text('please select number of cabins');
                $(this).closest('.accordion-body').find('.pass-val').text('please select number of passengers');
            }

            else if(!($(this).closest('.accordion-body').find('.cabin-select').val() > 0)) {
                //validation here
                $(this).closest('.accordion-body').find('.cab-val').text('please select number of cabins');
            }
            
            else if(!($(this).closest('.accordion-body').find('.passenger-select').val() > 0)) {
                //validation here
                $(this).closest('.accordion-body').find('.pass-val').text('please select number of passengers');
            }

        });

        //popup close
        $(document).on('click', '.pop_close', function(){
            $('.passengers').removeClass('pactive'); 
        });
        //popup close
        
        //add extension
        let ufgExtension = {};
        if (UFGStorage['extensions'] ) {
         ufgExtension = UFGStorage['extensions'];
             // console.log(ufgExtension);
         }

         $('.cabin-select').val($('.cabin-select').val());
         $('.passenger-select').val($('.passenger-select').val());

         $('.select_btn').click(function() {

            if( $(this).hasClass("active") ) {
                $(this).removeClass("active");
                $(this).text('Add this Extension');
                var exid = $(this).attr("data-id");
                var num = $(this).attr("data-num");
                if ( ufgExtension[exid] != undefined ) {
                    delete ufgExtension[exid];
                    // console.log(ufgExtension);
                }
                
            } 
            else {
                $(this).addClass("active");
                $(this).text('Remove this Extension');
                var exid = $(this).attr("data-id");
                var num = $(this).attr("data-num");
                ufgExtension[exid] = { 'pid': exid, 'num': num }

            }

            UFGStorage['extensions'] = ufgExtension;
            setUfgStorage(UFGStorage);
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
            setUfgStorage(UFGStorage);
            $(this).closest('.accordion-body').find('.cab-val').hide();
            $(this).closest('.accordion-body').find('.passenger-select').html('<option>No of Passengers</option>'); 
            for (var i = 1; i <= (parseInt($(this).val()) * 2); i++) {
                $(this).closest('.accordion-body').find('.passenger-select').html($(this).closest('.accordion-body').find('.passenger-select').html() + '<option value="'+ i +'">'+ i +'</option>' ); 
            }
        });

        $(".passenger-select").change(function(){
            UFGStorage['passenger'] = $(this).val()
            setUfgStorage(UFGStorage)
            $(this).closest('.accordion-body').find('.pass-val').hide(); 
        });
        // console.log('sold ouuuuuut' + $(".avl3").length);
        // if($(".avl3").length == 1){
        // $('.avl3').closest('.accordion-head').addClass('disabled');
        // }


        for (let i = 0; i < 4; i++) {
            var id = 36
            if ( UFGStorage['ext_' + i] ) {
                $("#input_20_"+id).val( UFGStorage['ext_' + i] );
                id++
                $("#input_20_"+id).val( UFGStorage['ext_' + i] );
                id++
            }
            
        }

        setUfgStorage(UFGStorage)

    });
</script>
<?php
}

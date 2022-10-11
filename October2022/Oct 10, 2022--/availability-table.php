<style type="text/css">
section.accordion-sec .table-wrapper .table-head { display: flex; flex-wrap: wrap; justify-content: space-between; margin: 0 0 30px 0; }
section.accordion-sec .table-wrapper .table-head .head-col { width: 19%; text-align: center; font-weight: bold; padding: 10px 0; }
.table-wrapper .table-body .accordion-set .accordion-head {display: flex;flex-wrap: wrap;justify-content: space-between;padding: 10px;background: #2a64a9;}
.table-wrapper .table-body .accordion-set .accordion-head .col { width: 19%; text-align: center; color: #fff; }
.table-wrapper .table-body .accordion-set  .accordion-body {display: none;background: #eee;padding: 0 10px;}
.table-wrapper .table-body .accordion-set .accordion-body .select-cabin { max-width: 20%; width: 100%; padding: 10px 0; font-weight: bold; text-align: center; }
.table-wrapper .table-body .accordion-set .accordion-body .cabin-details { width: 100%; display: flex; flex-wrap: wrap; justify-content: space-between; padding: 10px 0; margin: 0 0 10px 0; }
.table-wrapper .table-body .accordion-set .accordion-body .cabin-details .col { width: 19%; text-align: center; }
.table-wrapper .table-body .accordion-set .accordion-body .booking-btn { width: 100%; padding: 10px 0; text-align: right; }
.table-wrapper .table-body .accordion-set .accordion-body .booking-btn a { display: inline-block; padding: 10px 15px; background: #2a64a9; color: #fff; text-decoration: none; border-radius: 5px; }
</style>

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
//repeator loop 
if( have_rows('availability_table') ):
    while( have_rows('availability_table') ) : the_row();
    $price = get_sub_field('price')
    ?>
    <div class="accordion-set">
    <div class="accordion-head">
    <div class="col ac-date"><?php echo get_sub_field('date'); ?></div>
    <input type="hidden" value="<?php echo get_sub_field('date'); ?>" class="date">
    <div class="col ac-price"><?php echo _currency_format($price, true); ?></div>
    <input type="hidden" value="<?php echo get_sub_field('price'); ?>" class="price">
    <div class="col ac-avl"><?php echo get_sub_field('availability'); ?></div>
    <input type="hidden" value="<?php echo get_sub_field('availability'); ?>" class="avl">
    </div>
    <div class="accordion-body">
    <div class="select-cabin">Select Cabin</div>
    <select class="cabin-select">
    <option>No of Cabins</option>
    <!-- loop for cabins -->
    <?php for ($i=1; $i < 11 ; $i++) { ?>
        <!-- cabin option value -->
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php } ?>
        </select>
        <select class="passenger-select">
        <option>No of Passengers</option>
        <!-- loop for passengers -->
        <?php for ($i=1; $i < 21 ; $i++) { ?>
            <!-- passenger potion value -->
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
            </select>
            <div class="booking-btn"><a href="javascript:;">Check Availability & Book</a></div>
            </div>
            <?php
        endwhile;
        // No value.
        else :
            echo 'Sorry! No details matching your repeater was found.<br>';
        endif;
        ?>
        </div>
        
        </div>
        </div>
        </div>
        </section>
        
        <script type="text/javascript">
        jQuery(function($) {
            
            $('.booking-btn a').click(function(){
                if ($(".passengers").length){
                    $(".passengers").attr("class", "full-section passengers pactive");
                    console.log('clicked')
                } else {
                    console.log('class not found')
                }
            });
            
            //popup close
            jQuery(document).on('click', '.pop_close', function(){
                jQuery('.passengers').removeClass('pactive'); 
            });
            //popup close
            
            //add extension
            
            $('.select_btn').click(function(){
                
                if( $(this).hasClass("active") ) {
                    $(this).removeClass("active");
                    $(this).text('Add this Extension')
                } 
                else {
                    $(this).addClass("active");
                    $(this).text('Remove this Extension')
                }
                
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
                var date = $(this).closest('.price').val();
                if (date) {
                    console.log('date found :'+ date);
                }
                else
                console.log('error occured');
                //    var data = $(".cabin-select").val();
                //    console.log('date found :'+ date);
                
            });
        });
        </script>
        <?php
        
        ?>
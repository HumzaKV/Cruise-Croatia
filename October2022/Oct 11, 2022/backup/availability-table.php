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
    <div class="select-cabin">Select Cabin</div>
    <select class="cabin-select" id="<?php echo $n; ?>">
    <option>No of Cabins</option>
    <!-- loop for cabins -->
    <?php for ($i=1; $i < 11 ; $i++) { ?>
        <!-- cabin option value -->
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php } ?>
        </select>
        <select class="passenger-select" id="<?php echo $n; ?>">
        <option>No of Passengerrrs</option>
        <!-- loop for passengers -->
        <?php for ($i=1; $i < 21 ; $i++) { ?>
            <!-- passenger potion value -->
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
            </select>
            <div class="booking-btn"><a href="javascript:;">Check Availability & Book</a></div>
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
        </div>
        </section>
<?php
add_action('wp_footer', 'jscode_avaibility');
function jscode_avaibility() {
?>
    <script>
    jQuery(function($) {
        console.log(333)
        // localStorage.clear();

        function setUfgStorage(obj) {
            localStorage.setItem('UFGStorage', JSON.stringify(obj))
        }

        function getUfgStorage() {
            let x = JSON.parse( localStorage.getItem('UFGStorage') )
            if( x == null ) {
                x = {post_id: <?= get_the_ID(); ?>}
                setUfgStorage(x)
            }
            return x
        }

        let UFGStorage = getUfgStorage();

        $('.booking-btn a').click(function(){
            if ($(".passengers").length){
                $(".passengers").attr("class", "full-section passengers pactive");
            } else {
                console.log('class not found')
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
                    // var exten = localStorage.getItem('ext');
                    // UFGStorage['ext_'+num] = exid;
                    delete ufgExtension[exid]
                }
                
            } 
            else {
                console.log('add')
                $(this).addClass("active");
                $(this).text('Remove this Extension');
                var exid = $(this).attr("data-id");
                var num = $(this).attr("data-num");
                ufgExtension[exid] = { 'pid': exid, 'num': num }
                // else
                // var num = $(this).attr("data-num");
                // UFGStorage['ext_'+num] = exid;
                // console.log('date found :'+  localStorage.getItem('date') +' price :'+  localStorage.getItem('price') +' availablity :'+ localStorage.getItem('avl') +' cabin :'+  localStorage.getItem('cabin') +' passenger :'+ localStorage.getItem('passenger'));
                // console.log(localStorage.getItem('ext_'+num));
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
        
        $("#input_20_32").val( UFGStorage['date'] );
        console.log('Date: ' + $("#input_20_32").val());
        $("#input_20_33").val( UFGStorage['price'] );
        console.log('Price: ' + $("#input_20_33").val());
        $("#input_20_34").val( UFGStorage['avl'] );
        console.log('Availablity: ' + $("#input_20_34").val());
        $("#input_20_35").val( UFGStorage['cabin'] );
        console.log('Cabin: ' + $("#input_20_35").val());
        $("#input_20_31").val( UFGStorage['passenger'] );
        console.log('Passenger: ' + $("#input_20_31").val());

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

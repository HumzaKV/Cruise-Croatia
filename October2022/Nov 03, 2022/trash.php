<div class="accordion-set">

                                <div class="accordion-head">
                            <div class="col ac-date"><?php echo get_sub_field('date'); ?></div>
                            <input type="hidden" value="<?php echo get_sub_field('date'); ?>" class="date<?php echo $n ?>">

                            <?php
                            $featured_post = get_sub_field('ship');
                            if( $featured_post ): ?>
                                <div class="col ac-ship"><?php echo esc_html( $featured_post->post_title ); ?></div>
                                <input type="hidden" value="<?php echo esc_html( $featured_post->post_title ); ?>" class="ship<?php echo $n ?>">

                            <?php endif; ?>
                            <div class="col ac-price"><?php echo _currency_format($price, true); ?></div>
                            <input type="hidden" value="<?php echo get_sub_field('price'); ?>" class="price<?php echo $n ?>">
                            <div class="col ac-avl"><?php echo $avl; ?></div>
                            <input type="hidden" value="<?php if ($avl == 'Available') echo 1; elseif ($avl == 'Limited Cabins') echo 2; elseif ($avl == 'Sold Out') echo 3; ?>" class="avl<?php echo $n ?>">
                    </div> <!-- accordion-head end -->
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
                                </div> <!-- cabines-area styler end -->
                                <div class="passenger-area styler">
                                    <label for="<?php echo $n; ?>">Select Passenger</label>
                                    <select class="passenger-select" id="<?php echo $n; ?>">
                                        <option>No of Passengers</option>
                                    </select>
                                    <span class="text-danger pass-val"></span>
                                </div> <!-- passenger-area styler end -->
                                <div class="booking-btn styler"><a class="btn btn-green" href="javascript:;">Check Availability & Book</a></div>
                            </div> <!-- accordion_cover end -->
                        </div> <!-- accordion-body end -->
                </div> <!-- accordion-set END -->
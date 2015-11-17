<?php
/***********
 * Add navigation tabs to different forms
 ****************************************/
 function camella_form_tabs( $content ){
        $top = '';
        
        if( is_page() ){
                $slug = get_post()->post_name;
                if( in_array( $slug, array(
                        'sales-inquiries',
                        'customer-concerns',
                        'proposals',
                        'job-application'
                ))){
                        $top .= sprintf('<a href="%s"><button type="button" class="btn btn-primary btn-lg calculator-calculate">%s</button></a>',
                                        esc_url( home_url( '/sales-inquiries/' ) ),
                                        __('Sales Inquiry'));
                        $top .= sprintf('<a href="%s"><button type="button" class="btn btn-primary btn-lg calculator-calculate">%s</button></a>',
                                        esc_url( home_url( '/customer-concerns/' ) ),
                                        __('Customer Concerns'));
                        $top .= sprintf('<a href="%s"><button type="button" class="btn btn-primary btn-lg calculator-calculate">%s</button></a>',
                                        esc_url( home_url( '/category/careers/' ) ),
                                        __('Careers'));
                        $top .= sprintf('<a href="%s"><button type="button" class="btn btn-primary btn-lg calculator-calculate">%s</button></a>',
                                        esc_url( home_url( '/proposals/' ) ),
                                        __('Proposals'));
                        
                        $top = sprintf('<div class="text-center topnav-buttons">%s</div>', $top);
                }
        }
        return $top . $content;
 }
 add_filter( 'the_content', 'camella_form_tabs' );
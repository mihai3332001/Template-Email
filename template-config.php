<?php

/**

 * Template Configuration

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/template-config.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see     https://docs.woocommerce.com/document/template-structure/

 * @author  WooThemes

 * @package WooCommerce/Templates

 * @version 3.3.0

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



$user_id = get_current_user_id();
$user = new WC_Customer($user_id);
//var_dump($user);

$category = "Templates";
function selectCatbyID($category) {
	global $wpdb;
	$table_terms = $wpdb->prefix . "terms";
	$cat_id = $wpdb->get_var($wpdb->prepare (
		"SELECT DISTINCT $table_terms.term_id FROM $table_terms WHERE 
		$table_terms.name = %s",
		$category
	));
	return $cat_id;
}
$cat_id = selectCatbyID($category);


$products_by_orders_ids_array = retrieve_orders_ids($user_id, $cat_id);

//var_dump($orders_ids_array);



function retrieve_orders_ids($user_id, $cat_id) {

	global $wpdb;

	$table_posts = $wpdb->prefix . "posts";

	$table_postmeta = $wpdb->prefix . "postmeta";

	$table_items = $wpdb->prefix . "woocommerce_order_items";

	$table_itemeta = $wpdb->prefix . "woocommerce_order_itemmeta";

	$table_terms = $wpdb->prefix . "terms";

	$table_term_taxonomy = $wpdb->prefix . "term_taxonomy";

	$table_term_relationships = $wpdb->prefix . "term_relationships";

	$orders_statuses = "wc-completed";



	$orders_ids = $wpdb->get_col("

		SELECT DISTINCT $table_itemeta.meta_value

		FROM $table_itemeta, $table_items, $table_posts, $table_postmeta, $table_term_relationships, $table_term_taxonomy, $table_terms

		WHERE $table_items.order_item_id = $table_itemeta.order_item_id

		AND $table_items.order_id = $table_posts.ID

		AND $table_posts.post_status LIKE '$orders_statuses'

		AND $table_posts.ID =  $table_postmeta.post_id

		AND $table_postmeta.meta_key LIKE '_customer_user'

		AND $table_postmeta.meta_value LIKE '$user_id'

		AND $table_itemeta.meta_key LIKE '_product_id'

		AND $table_itemeta.meta_value = $table_term_relationships.object_id

		AND $table_term_relationships.term_taxonomy_id LIKE '$cat_id'

		AND $table_term_taxonomy.term_id = $table_terms.term_id

		ORDER BY $table_items.order_item_id DESC

		");



 return $orders_ids;

}



if(!empty($products_by_orders_ids_array)) {

	?>



		



  <div class="step-wizard">

    <div class="progress">

      <div class="progressbar empty"></div>

      <div id="prog" class="progressbar"></div>

    </div>

    <ul>

      <li class="active">

        <a href="#" id="step1">

          <span class="step">1</span>

          <span class="title">Select Template</span>

        </a>



      </li>

      <li class="">

        <a href="#" id="step2">

          <span class="step">2</span>

          <span class="title">Property Information</span>

        </a>

      </li>

      <li class="">

        <a href="#" id="step3">

          <span class="step">3</span>

          <span class="title">Property Description</span>

        </a>

      </li>

       <li class="">

        <a href="#" id="step4">

          <span class="step">4</span>

          <span class="title">Property Images</span>

        </a>

      </li>

    </ul>

  </div>






 

<form action="<?php echo get_site_url() . '/my-account/template-settings/'; ?>" method="post" class="form" id="validationForm" enctype="multipart/form-data" validate>

<div id="step1Form">

	<?php

	foreach ($products_by_orders_ids_array as $product_id) {

	?>

	<div class="col-md-4 selectBox">

	<div class="selectRadio">

	<input type="radio" class="selectByRadio is-valid" name="template" value="<?php echo $product_id; ?>" required>

	</div>

	<img src="<?php echo get_the_post_thumbnail_url($product_id); ?>" class="img-responsive picSelect">

	</div>

	<?php

	}

	?>

</div>

<div id="step2Form">

 <div class="property-information ">



        <h3>Property Information</h3>



        <div class="form-group row">



            <label for="inputMLS validationServer01" class="col-lg-4  col-form-label text-lg-right">MLS Number</label>



            <div class="col-md-4 ">



                <input type="text" class="form-control is-valid" maxlength="10" id="inputMLS validationServer01" name="mlsNumber" placeholder="" >



            </div>



        </div>



        <div class="form-group row">



            <label for="inputCity validationServer02" class="col-lg-4 col-form-label text-lg-right">MLS Area/City Code</label>



            <div class=" col-md-4 ">



                <input type="text" class="form-control is-valid" name="mlsArea" id="inputCity validationServer02" placeholder="" >



            </div>



        </div>



        <div class="form-group row">



            <label for="inputAddress validationServer03" class="col-lg-4 col-form-label text-lg-right">Full Property Address<span>*</span></label>



            <div class="col-md-7  address">



                <input type="text" class="form-control is-valid" name="fullAddress" id="inputAddress" maxlength="50" placeholder=""required>



                <p>Please include the CITY and ZIP of your property listing!</p>



                <p >(50 characters max)</p>



            </div>



        </div>



        <div class="form-group row">



            <label for="listPrice" class="col-lg-4 col-form-label text-lg-right">List Price<span>*</span></label>



            <div class="col-md-6 d-flex list-price">



                <span>$</span>



                <input type="number" lang="en" class="form-control is-valid" maxlength="10" name="listPrice" id="listPrice" placeholder="" required>



            </div>



        </div>



    </div> <!-- /property-information-->


<div class="agent-information">



        <h3>Agent Information</h3>



        <div class="form-group row">



            <label for="agentName" class="col-lg-4  col-form-label text-lg-right"><span>*</span>Agent Name</label>



            <div class="col-md-8 ">



                <input type="text" class="form-control is-valid" id="agentName" name="agentName" placeholder="" value="<?php echo $user->get_first_name() . ' ' . $user->get_last_name() ; ?>" required>



            </div>



        </div>


        <div class="form-group row">



            <label for="businessAddress" class="col-lg-4  col-form-label text-lg-right">Business Address</label>



            <div class="col-md-8 ">



                <input type="text" class="form-control is-valid" id="businessAddress" name="businessAddress" placeholder="" value="<?php echo $user->get_billing_address() ; ?>" >



            </div>



        </div>


 	<div class="form-group row">



            <label for="businessName" class="col-lg-4  col-form-label text-lg-right">Company Name</label>



            <div class="col-md-8 ">



                <input type="text" class="form-control is-valid" id="businessName" name="businessName" placeholder="" value="<?php echo $user->get_billing_company() ; ?>" >



            </div>



        </div>


 	<div class="form-group row">



            <label for="phoneNumber" class="col-lg-4  col-form-label text-lg-right"><span>*</span>Phone Number</label>



            <div class="col-md-8 ">



                <input type="text" class="form-control is-valid" id="phoneNumber" maxlength="12" name="phoneNumber" placeholder="" value="<?php echo $user->get_billing_phone() ; ?>" required>



            </div>



        </div>


	<div class="form-group row">



            <label for="emailAddress" class="col-lg-4  col-form-label text-lg-right"><span>*</span>Email Adddress</label>



            <div class="col-md-8 ">



                <input type="email" class="form-control is-valid" id="emailAddress" name="emailAddress" placeholder="" value="<?php echo $user->get_email() ; ?>" required>



            </div>

</div>



 <div class="uploud-photo ">

        <h3>Upload</h3>

			<div class="form-group">
                    <label for="inputUploudPhoto" ><span class="font-weight-bold">Upload Agent Photo </span></label>

                    <div class="custom-file choose-file">

                        <input type="file" class="custom-file-input" id="inputUploudPhoto" name="photoAgent">

                        <p>Only jpeg, jpg and png.Max upload 2 MB.</p>

                        <label class="custom-file-label" for="validatedCustomFile">Choose file..</label>

                       
                    </div>
			</div>


                <label for="inputUploudPhoto" ><span class="font-weight-bold">Upload Company Logo</span></label>

                <div class="custom-file choose-file">

                    <input type="file" class="custom-file-input" id="inputUploudLogo" name="photoLogo">

                    <p>Only png file.Max upload 2 MB.</p>

                    <label class="custom-file-label" for="inputUploudLogo">Choose file..</label>

                    <div class="invalid-feedback">Example invalid custom file feedback</div>

                </div> <br /><br />

		<div class="form-group">

                <label for="logourl" class="font-weight-bold" ><span class="font-weight-bold">Company URL: </span></label>

                	<div class="input-group">

                <input type="url" class="form-control" id="logourl" aria-describedby="basic-addon3" name="logourl"  placeholder="http://www.link.com">
                    </div>
                <span>The link must being with http://</span>
			

            	</div>

 		<div class="form-group row">



         	<label for="color_value" class="col-lg-12 col-form-label text-lg-left font-weight-bold"><span class="font-weight-bold">Select Color for Background Logo</span></label>



            <div class="col-md-12 d-flex">



                <input name="color2" class="jscolor {required:false, hash:true}" >          


            </div>



        </div>   


</div>



      


    </div> <!-- /agent-information-->




	</div> <!-- step2Form -->



	<div id="step3Form">

		<div class="property-description">



        <h3>Property Description</h3>







        <div class="form-group row">



            <label for="inputSubject validationServer05" class="col-lg-4  col-form-label text-lg-right">Headline/Subject<span>*</span></label>



            <div class="col-md-7 subject">



                <input type="text" class="form-control is-valid" name="headline" id="inputSubject" maxlength="50" placeholder="" required>



                <p>(50 characters max)</p>



            </div>



        </div>



        <div class="form-group row">



            <label for="textareaDescription validationServer06" class="col-lg-4 col-form-label text-lg-right">Description<span>*</span></label>



            <div class=" col-md-8 description">



                <textarea  class="form-control is-valid" id="textareaDescription" rows="4" maxlength="500" name="description" placeholder="Insert written description from house here (500 characters max)" required></textarea>



                <p id="count">Remaining characters : <span class="descriptionLetters"></span></p>



            </div>



        </div>


        <div class="form-group row">



            <label for="inputHighlights" class="col-lg-4 col-form-label text-lg-right">Highlights</label>



            <div class="col-md-6 highlights d-flex">



                <span>1.</span><input type="text" class="form-control" maxlength="25" name="highlight1" id="inputHighlights1" placeholder="(25 characters max per line)">



            </div>



        </div>



        <div class="form-group row">



            <label for="inputHighlights" class="col-lg-4 col-form-label text-lg-right"></label>



            <div class="col-md-6 highlights d-flex">



                <span>2.</span><input type="text" class="form-control" maxlength="25" name="highlight2" id="inputHighlights2" placeholder="">



            </div>



        </div>



        <div class="form-group row">



            <label for="inputHighlights" class="col-lg-4 col-form-label text-lg-right"></label>



            <div class="col-md-6 highlights d-flex">



                <span>3.</span><input type="text" class="form-control" maxlength="25" name="highlight3" id="inputHighlights3" placeholder="">



            </div>



        </div>



        <div class="form-group row">



            <label for="inputHighlights" class="col-lg-4 col-form-label text-lg-right"></label>



            <div class="col-md-6 highlights d-flex">



                <span>4.</span><input type="text" class="form-control" maxlength="25" name="highlight4" id="inputHighlights4" placeholder="">



            </div>



        </div>



        <div class="form-group row">



            <label for="inputHighlights" class="col-lg-4 col-form-label text-lg-right"></label>



            <div class="col-md-6 highlights d-flex">



                <span>5.</span><input type="text" class="form-control" maxlength="25" name="highlight5" id="inputHighlights5" placeholder="">



            </div>



        </div>



        <div class="form-group row">



            <label for="inputHighlights" class="col-lg-4 col-form-label text-lg-right"></label>



            <div class="col-md-6 highlights d-flex">



                <span>6.</span><input type="text" class="form-control" maxlength="25" name="highlight6" id="inputHighlights6" placeholder="">



            </div>



        </div>



        <div class="form-group row">



            <label for="inputHighlights" class="col-lg-4 col-form-label text-lg-right"></label>



            <div class="col-md-6 highlights d-flex">



                <span>7.</span><input type="text" class="form-control" maxlength="25" name="highlight7" id="inputHighlights7" placeholder="">



            </div>



        </div>



        <div class="form-group row">



            <label for="inputHighlights" class="col-lg-4 col-form-label text-lg-right"></label>



            <div class="col-md-6 highlights d-flex">



                <span>8.</span><input type="text" class="form-control" maxlength="25" name="highlight8" id="inputHighlights8" placeholder="">



            </div>



        </div>



        <div class="form-group row">



            <label for="inputHighlights" class="col-lg-4 col-form-label text-lg-right"></label>



            <div class="col-md-6 highlights d-flex">



                <span>9.</span><input type="text" class="form-control" maxlength="25" name="highlight9" id="inputHighlights9" placeholder="">



            </div>



        </div>



       <!--  <div class="form-group row">



            <label for="inputHighlights" class="col-lg-4 col-form-label text-lg-right"></label>



            <div class="col-md-6 highlights d-flex">



                <span>10.</span><input type="text" class="form-control" maxlength="25" name="highlight10" id="inputHighlights10" placeholder="">



            </div>



        </div>



        <div class="form-group row">



            <label for="inputHighlights" class="col-lg-4 col-form-label text-lg-right"></label>



            <div class="col-md-6 highlights d-flex">



                <span>11.</span><input type="text" class="form-control" maxlength="25" name="highlight11" id="inputHighlights11" placeholder="">



            </div>



        </div>



        <div class="form-group row">



            <label for="inputHighlights" class="col-lg-4 col-form-label text-lg-right"></label>



            <div class="col-md-6 highlights d-flex">



                <span>12.</span><input type="text" class="form-control" maxlength="25" name="highlight12" id="inputHighlights12" placeholder="">



            </div>



        </div> -->



    </div> <!-- /property-description-->







    <!--More Info Link-->



    <div class="info-link ">



        <h3>More Info Link</h3>



        <p>You may insert a link to your vitual tour, slide show, or other page with more information <b>about this property only.</b>



         Please insert the entire URL, i.e. include 'http://' or similar prefix.</p>



        <p>HINT: Open the page in your browser, and cut and paste the address from the address bar into the field below.</p>



        <div class="form-group row">



            <label for="inputURL" class="col-lg-3  col-form-label text-lg-right">Link URL</label>



            <div class="col-md-9 subject">



                <input type="url" class="form-control" id="inputURL" name="linkUrl" placeholder="http://www.link.com">

                <span>The link must being with http://</span>



            </div>



        </div>



        <div class="form-group row">



            <label for="inputLinkDescription" class="col-lg-3  col-form-label text-lg-right">Link Description</label>



            <div class="col-md-9">



                <input type="text" class="form-control" id="inputLinkDescription" name="linkDescription" placeholder="Read More">



            </div>



        </div>



        <!-- <div class="form-group row linkAgreement">



            <label  for="inlineCheckbox1" class="form-check-label col-lg-3  text-lg-right">Link Agreement</label>



            <div class="col-md-9 ">



                <input  type="checkbox" class="form-check-input position-static" id="blankCheckbox" value="option1" aria-label="...">



                <span>Click this checkbox to agree that the above link is for more information associated with this property only.</span>



            </div>



        </div> -->



        <!-- <div class="form-group row linkTest">



            <label  for="inlineCheckbox2" class="form-check-label col-lg-3  text-lg-right">Link Test</label>



            <div class="col-md-9 ">



            <span><a href="url">Click here to test your link,</a> which will be opened in a new window. Close the new window to return to this form.</span>



            </div>



        </div> -->



        

	</div> 	<!-- step3Form -->
</div>

    <div id="step4Form">
        <div class="property-images">

        <h3>Property Images</h3>

        <div class="form-group">
                    <label for="propertyImg" ><span class="font-weight-bold">Upload Main Photo For Property</span></label>

                    <div class="custom-file choose-file">

                        <input type="file" class="custom-file-input" id="propertyImg" name="propertyImage1">

                        <p>Only jpeg, jpg and png.Max upload 2 MB.</p>

                        <label class="custom-file-label" for="validatedCustomFile">Choose file..</label>

                    </div>

                    <label for="propertyImg" ><span class="font-weight-bold">Upload Image 2 For Property</span></label>

                    <div class="custom-file choose-file">

                        <input type="file" class="custom-file-input" id="propertyImg" name="propertyImage2">

                        <p>Only jpeg, jpg and png.Max upload 2 MB.</p>

                        <label class="custom-file-label" for="validatedCustomFile">Choose file..</label>
                       
                    </div>
                    <label for="propertyImg" ><span class="font-weight-bold">Upload Image 3 For Property</span></label>

                    <div class="custom-file choose-file">

                        <input type="file" class="custom-file-input" id="propertyImg" name="propertyImage3">

                        <p>Only jpeg, jpg and png.Max upload 2 MB.</p>

                        <label class="custom-file-label" for="validatedCustomFile">Choose file..</label>

                       
                    </div>

                    <label for="inputUploudPhoto" ><span class="font-weight-bold">Upload Image 4 For Property</span></label>

                    <div class="custom-file choose-file">

                        <input type="file" class="custom-file-input" id="propertyImg" name="propertyImage4">

                        <p>Only jpeg, jpg and png.Max upload 2 MB.</p>

                        <label class="custom-file-label" for="validatedCustomFile">Choose file..</label>

                       
                    </div>

                    <label for="inputUploudPhoto" ><span class="font-weight-bold">Upload Image 5 For Property</span></label>

                    <div class="custom-file choose-file">

                        <input type="file" class="custom-file-input" id="propertyImg" name="propertyImage5">

                        <p>Only jpeg, jpg and png.Max upload 2 MB.</p>

                        <label class="custom-file-label" for="validatedCustomFile">Choose file..</label>

                       
                    </div>

            </div>

                
            <div class="form-group btnSend">
            <button class="btn btn-lg"  type="submit" id="buttonSend">Send</button>
            </div>
        </div>
    </div>





	<!-- <button type="submit" name="submit">Submit</button> -->

</form>

  <div class="buttons">

    <button class="btnNext btn" id="prev">prev</button>

    <button class="btnPrev btn" id="next">next</button>

  </div>

	<?php

} else {

	echo __("No template! You must buy a template for config.");

}





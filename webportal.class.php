<?php
class WebPortal {
	private $itemID = 0;
	private $itemRecord = array();
	private $scriptAction = '';
	private $formData = array();
	function __construct(){
		if(!empty($_GET['itemID'])){
			$this->itemID = $_GET['itemID'];
		} else {
			$this->itemID = '002';
		}
		if(!empty($_GET['action'])){
			$this->scriptAction = $_GET['action'];
		}
		if(count($_POST)){
			foreach($_POST as $key=>$value){
				if(is_array($value)){
					$this->formData[$key] = array();
					foreach($value as $subValue){
						$this->formData[$key][] = stripslashes($subValue);
					}
				} else {
					$this->formData[$key] = stripslashes($value);
				}
			}
		}
		$this->loadItemRecord();
		$this->displayHeader();
		$this->portalDirector();
		$this->displayFooter();
	}
	private function loadItemRecord(){
		switch($this->itemID){
			case '003':
				$this->itemRecord = array(
				'title'=>'LONG PRODUCT NAME',
				'status'=>'inactive',
				'paypal_button_id'=>'',
				'cutoff_time'=>'2010-10-11 09:00:00',
				'image'=>'<img src="images/poster_image.jpg" border="0" alt="" />',
				'description'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean turpis purus, consequat nec aliquam eu, tempor eu eros. Cras vitae mauris mollis turpis volutpat gravida. Pellentesque suscipit blandit cursus. Donec suscipit dolor et lectus pulvinar consequat. Praesent vitae imperdiet ligula. Curabitur tincidunt leo ac justo consectetur laoreet. Fusce quis est dui, vel placerat nunc. Quisque lacinia nisi ac eros tristique non tincidunt magna adipiscing. Duis ut tortor a justo varius dapibus. Nunc commodo accumsan libero, vitae consectetur nulla adipiscing nec. Praesent non justo urna.',
				'cost'=>'$10'
				);
				break;
			case '002':
				$this->itemRecord = array(
				'title'=>'2011 International Goodjer Day Print (Pre-Order)',
				'status'=>'active',
				'style'=>'wide',
				'width'=>'686',
				'height'=>'480',
				'paypal_button_id'=>'',
				'cutoff_time'=>'2012-01-05 03:00:00',
				'special_cutoff_time'=>'2011-12-14 03:00:00',
				'special_cutoff_reason'=>'Christmas',
				'image'=>'2011_print.jpg',
				'large_image'=>'',//2011_print_large.jpg
				'description'=>"<p style='margin-top:7px;'>Charity is a funny thing. We know that it's good to give but often we need a little something extra to get us motivated enough to chip in. Giving is fun but getting in return makes it so much better.</p>
				<p>With that in mind, I'd like to present the 2011 GWJ Fundraising poster made by our own <a href='http://www.gamerswithjobs.com/user/8234' target='_blank' style='color:#d33a1c;'>bombsfall</a>. Talking it up would just ruin it. Just <i>look</i> at that thing.</p>
				<p>So this season, the one that you're encouraged to give so much, feel free to get yourself something awesome while you do it. Shipping is included in the price and 100% of the profit goes to <a href='http://www.childsplaycharity.org' target='_blank' style='color:#d33a1c;'>Child's Play</a>.</p>
				<p><table cellspacing='0'>
					<tr>
						<td><img src='images/bombsfall.png' alt='' width='60' height='60'></td>
						<td>&nbsp;</td>
						<td valign='top'>
							<b>About the Artist:</b><br>
							<br>
							Scott Benson is an animator and illustrator. His work can be seen at <a href='http://bombsfall.com' target='_blank' style='color:#d33a1c;'>bombsfall.com</a>
						</td>
					</tr>
				</table>
				</p>
				<p><i><b>A note about shipping:</b> We take orders in batches. The cut-off times are for their respecitive batches so we can make sure everyone gets their prints at around the same time.</i></p>",
				'cost'=>'$20'
				);
				break;
			case '001':
			default:
				$this->itemRecord = array(
				'title'=>'2010 International Goodjer Day Print (Pre-Order)',
				'status'=>'active',
				'style'=>'tall',
				'width'=>'326',
				'height'=>'466',
				'paypal_button_id'=>'',
				'cutoff_time'=>'2010-10-13 09:00:00',
				'special_cutoff_time'=>'',
				'special_cutoff_reason'=>'',
				'image'=>'2010_print.jpg',
				'large_image'=>'',
				'description'=>'<i>Its bun was toasted a deep brown<br/>
like tree bark in the dead of winter;<br/>
the end of its fuse was as a flame of fire<br/>
And its sausage shone like unto brass,<br/>
as if its ember burned in a furnace;<br/>
And its voice the sound of many waters<br/>
And of an unspeakable colour was the mustard,<br/>
roiling across the wiener as if mercury<br/>
And when I saw it rise from the blackness of space,<br/>
I fell at its feet as dead.</i><br/>
<div align="left">&mdash;Book of the Wiener Bomb, 10:23</div></i><br/>
The signs are mounting; be prepared! October 23rd, 2010 is International Goodjer Day, and on that day we Goodjers will throw our thumbs in the air as one! Commemorate the occasion for all eternity with this handsome 14" × 20" high quality print. As Rabbit might say, it\'s the bomb! The <i>Wiener</i> Bomb!<br/>
<br/>
There is no shipping cost and all profits will be going to <a href="http://www.childsplaycharity.org" target="_blank" style="color:#d33a1c;">Child\'s Play</a>. If you\'ll be attending a Slap & Tickle on the day of the event and would like to pick it up there, let us know where you\'ll be attending when you order and we will make sure it\'s there for you when you arrive. Pre-orders will cease on October 12th and will ship shortly thereafter via USPS.',
				'cost'=>'$15'
				);
				break;
		}
	}
	private function portalDirector(){
		switch($this->scriptAction){
			case 'complete':
				$this->displayCompletedTransactionTable();
				break;
			case 'cancel':
			default:
				$this->displayProductTable();
				break;
		}
	}
	
	private function displayProductTable(){
		print '<table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td colspan="2" class="product_banner_name">'.$this->itemRecord['title'].'</td>
        </tr>
        <tr><td colspan="2" class="spacer_medium"><!--SPACER ROW--></td></tr>
        <tr>';
		if($this->itemRecord['status'] == 'active'){
			if(empty($this->itemRecord['cutoff_time']) || strtotime($this->itemRecord['cutoff_time']) > time()){
				$paypaylContent = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="'.$this->itemRecord['paypal_button_id'].'">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>';
			} else {
				$paypaylContent = '<i>The batch cutoff time has been reached</i>';
			}
		} else if($this->itemRecord['status'] == 'pending'){
			$paypaylContent = '<i>This item is not available yet</i>';
		} else {
			$paypaylContent = '<i>This item is no longer available</i>';
		}
		$largeImageExtra = "";
		if(!empty($this->itemRecord['large_image'])){
			$largeImageExtra = "style='cursor:pointer;' onclick=\"alert('{$this->itemRecord['large_image']}');\"";
		}
		$specialCutOffString = "";
		if(!empty($this->itemRecord['special_cutoff_time'])){
			$specialCutOffString = 'Order by '.date('D, M j\<\s\u\p>S\<\/\s\u\p\>',strtotime($this->itemRecord['special_cutoff_time'])).' for<br> '.$this->itemRecord['special_cutoff_reason'].' delivery';
		}
		$standardCutOffString = 'Order cut-off is '.date('D, M j\<\s\u\p>S\<\/\s\u\p\>',strtotime($this->itemRecord['cutoff_time']));
		if($this->itemRecord['style'] == 'tall'){
			print '<td align="center" width="50%" valign="top"><img src="images/'.$this->itemRecord['image'].'" width="'.$this->itemRecord['width'].'" height="'.$this->itemRecord['height'].'" border="0" alt="" '.$largeImageExtra.'></td>
            <td align="center" width="50%" valign="top">
                <table width="94%" cellpadding="0" cellspacing="0" border="0">                    
                    <tr><td width="100%" align="left">'.$this->itemRecord['description'].'</td></tr>
                    <tr><td class="spacer_7"><!--SPACER ROW--></td></tr>
                    <tr><td align="center" class="product_banner_name">'.$this->itemRecord['cost'].'</td></tr>
                    <tr><td class="spacer_7"><!--SPACER ROW--></td></tr>
                    <tr><td align="center">'.$paypaylContent.'</td></tr>';
			if(!empty($specialCutOffString)){
				print '<tr><td class="spacer_7"><!--SPACER ROW--></td></tr>
                    <tr><td align="center"><i>'.$specialCutOffString.'</i></td></tr>';
			}
			print '<tr><td class="spacer_7"><!--SPACER ROW--></td></tr>
				<tr><td align="center"><i>'.$standardCutOffString.'</i></td></tr>';
			print '</table>
            </td>';
		} else if($this->itemRecord['style'] == 'wide'){
			print '<td align="center" width="100%" valign="top"><img src="images/'.$this->itemRecord['image'].'" width="'.$this->itemRecord['width'].'" height="'.$this->itemRecord['height'].'" border="0" alt="" '.$largeImageExtra.'></td>
			</tr><tr>
			<td align="center" width="100%" valign="top">
			<table width="94%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="70%" align="left" valign="top">'.$this->itemRecord['description'].'</td>
				<td width="30%" align="center" valign="top">
				<div class="spacer_7"><!--SPACER DIV--></div>
				<div align="center" class="product_banner_name">Only '.$this->itemRecord['cost'].'</div>
				<div class="spacer_7"><!--SPACER DIV--></div>
				<div align="center">'.$paypaylContent.'</div>
				<div class="spacer_7"><!--SPACER DIV--></div>
				<div align="center"><i>Print size is 14" × 20"</i></div>';
			if(!empty($specialCutOffString)){
				print '<div class="spacer_7"><!--SPACER DIV--></div>
				<div align="center"><i>'.$specialCutOffString.'</i></div>';
			}
			print '<div class="spacer_7"><!--SPACER DIV--></div>
			<div align="center"><i>'.$standardCutOffString.'</i></div>';
			
			print '<div class="spacer_7"><!--SPACER DIV--></div>
			<div class="spacer_7"><!--SPACER DIV--></div>
			<div class="spacer_7"><!--SPACER DIV--></div>
			<div align="center">Want to support Child\'s Play<br>but not wanting a print?</div>
			<div class="spacer_7"><!--SPACER DIV--></div>
			<div align="center">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
			</div>';
			print '</td>
			</tr>
                </table>
            </td> ';
		}
		print '</tr>
    </table>';
	}
	private function displayCompletedTransactionTable(){
		print '<table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td colspan="2" class="product_banner_name">Transaction Complete!</td>
        </tr>
        <tr><td colspan="2" class="spacer_medium"><!--SPACER ROW--></td></tr>
        <tr><td width="100%" align="left">Thank you for your payment. Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at <a href="http://www.paypal.com/us" style="color:#d33a1c;">www.paypal.com/us</a> to view details of this transaction.</td></tr>
    </table>';
	}
	
	private function displayHeader(){
		print '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
		<head><title>
			GWJ Unofficial Swag
		</title>
		<link href="style.css" rel="stylesheet" type="text/css" />
		</head>
		<body>
        <div align="center">
            <table cellspacing="0" cellpadding="0" border="0" style="width:900px;">
                <tr>
                    <td width="100%" style="height:103px;background-color:#363636;" valign="top"><img src="images/header.png" border="0" alt="" width="900" height="90" /></td>
                </tr>
                <!--<tr><td style="height:13px;background-color:#363636;"><img src="images/thin_gray.png" border="0" alt="" width="900" height="13" /></td></tr>-->
                <tr><td class="spacer_medium"><!--spacer--></td></tr>
                <tr>
                    <td class="main_content" valign="top">';
	}
	private function displayFooter(){
		print '</td>
		                </tr>
		                <tr><td class="spacer"><!--spacer--></td></tr>
		                <tr>
		                    <td class="footer">Joshua Mills &mdash; Copyright '.date('Y').'</td>
		                </tr>
		            </table>
		        </div>
		    </form>
		</body>
		</html>';
	}
}
?>
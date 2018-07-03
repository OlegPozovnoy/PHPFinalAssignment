<form action="index.php" method="post"  enctype="multipart/form-data">
    <input type="hidden" name="action" value="save_book">
    <fieldset><legend>Books info</legend>
        
        <label for="title" >Book title:</label>
        <input name="title" id="title" type="text" placeholder="book title" maxlength="200" value="<?php if(!empty($book_title)) {echo $book_title;} ?>" required />
        
        <label for="book_genre" >Book genre:</label>
        <input name="book_genre" id="book_genre" type="text" placeholder="book genre" maxlength="60" value="<?php if(!empty($book_genre)) {echo $book_genre;} ?>" />
        
        <br/>       
		<label for="book_review" >Book review:</label>
        <textarea name="book_review" id="book_review" placeholder="type your review here" maxlength="1000" rows="5" cols="100"><?php if(!empty($book_shortreview)) {echo $book_shortreview;} ?></textarea> 
        
        <br/>
        <label for="img" >Books image(max 128kb jpeg/pjpeg/gif/png):</label>
        <input name="img" id="img" type="file"   accept="image/gif,image/jpeg,image/pjpeg,image/png" value="<?php if(!empty($book_image)) {echo $book_image;} ?>"/>
          
        <br/>      
		<label for="url" >Online store link:</label>
        <input name="url" id="url" type="url" placeholder="url" maxlength="250"  value="<?php if(!empty($book_url)) {echo $book_url;} ?>" />			
	</fieldset>
	<br/>
    <fieldset><legend>Your details</legend>
        <label for="name" >Your name:</label>
        <input name="name" id="name" readonly = "readonly" placeholder ="<?php echo filter_var($_SESSION['user_id']);?>" value="<?php echo filter_var($_SESSION['user_id']);/*if(!empty($user_name)) {echo $user_name;} */  ?>" required  />
	
        <label for="email" >Your email:</label>
        <input name="email" id="email" readonly = "readonly" placeholder = "<?php echo filter_var($_SESSION['email']);?>" value="<?php echo filter_var($_SESSION['email']);/*if(!empty($user_email)) {echo $user_email;}*/  ?>" />
	</fieldset>
	<br/>
	<fieldset>
		<input type="hidden" name="book_id" id="book_id" value="<?php if(!empty($book_id)) {echo $book_id;}?>"/>
		<input type="submit" value="Add" name="submit" />		
	</fieldset>
</form>

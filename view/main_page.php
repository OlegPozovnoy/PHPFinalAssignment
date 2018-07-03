<?php

	echo '<table class="table table-striped"><thead><th>Title</th><th>Genre</th>
		<th>Image</th><th>Review</th><th>Buy</th><th>Added by</th><th>Users email</th></thead><tbody>';

/* loop through the data, creating a new table row for each game
and putting each value in a new column */
	foreach($books as $book) {
		echo '<tr><td>' . $book['book_title'] . '</td>
        <td>' . $book['book_genre'] . '</td>
        <td><img src="'.GW_UPLOADPATH.$book['book_image'].'"alt="unavailable" height=80px width=45px /></td>
        <td #id = "review"><textarea rows="4" maxlength="1024"  readonly>' . $book['book_shortreview'] . '</textarea></td>
        <td>' . '<a href='.$book['book_url'].'>'.$book['book_url'].'</a></td>
		<td>' . $book['user_name'] . '</td>
		<td><a href="mailto:'.$book['user_email'].'">'.$book['user_email'].'</a></td>';
		}

// close the table
echo '</tbody></table>';
		


?>

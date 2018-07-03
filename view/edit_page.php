<?php
	echo '<table class="table table-striped"><thead><th>Title</th><th>Genre</th>
		<th>Review</th><th>Buy</th><th>Image</th><th>Added by</th><th>Users email</th><th>Edit</th><th>Delete</th></thead><tbody>';

/* loop through the data, creating a new table row for each game
and putting each value in a new column */
	foreach($books as $book) {
		echo '<tr><td>' . $book['book_title'] . '</td>
        <td>' . $book['book_genre'] . '</td>
        <td #id = "review"><textarea cols="50" rows="4" maxlength="1024" readonly>' . $book['book_shortreview'] . '</textarea></td>
        <td>' . '<a href='.$book['book_url'].'>'.$book['book_url'].'</a></td>
        <td><img src="'.GW_UPLOADPATH.$book['book_image'].'"alt="Books image" height=64px width=48px /></td>
		<td>' . $book['user_name'] . '</td>
		<td><a href="mailto:'.$book['user_email'].'">'.$book['user_email'].'</a></td>
        <td><a href="index.php?action=add_book&book_id=' . $book['book_id'] . '">Edit</a></td>
        <td>
        <a href="index.php?action=delete_book&book_id=' . $book['book_id'] .
            '" onclick="return confirm(\'Are you sure?\');">
            Delete</a></td></tr>';
		}

// close the table
echo '</tbody></table>';
?>
<?php
require 'classes/Database.php';
require 'classes/Tags.php';
$database = new Database;

$upload = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if(@$_POST['delete']) {
    $delete_id = $_POST  ['delete_id'];
    $database->query('DELETE FROM blog_posts WHERE id = :id');
    $database->bind(':id', $delete_id);
    $database->execute();
}

if(@$upload['update']) {
    $id = $upload['id'];
    $title = $upload['title'];
    $post = $upload['post'];
    $first_name = $upload['first_name'];



    $database->query('UPDATE blog_posts SET title = :title, post = :post, first_name = :first_name WHERE id = id'); $database->bind(':title', $title);
    $database->bind(':title', $title);
    $database->bind(':post', $post);
    $database->bind(':id', $id);
    $database->bind(':first_name', $first_name);
    $database->execute();
}

if(@$upload['submit']) {
    $title = $upload['title'];
    $post = $upload['body'];
    $first_name = $upload['first_name'];

    $database->query('INSERT INTO blog_posts (title, post, first_name) VALUES(:title, :post, :first_name)');
    $database->bind(':title', $title);
    $database->bind(':post', $post);
    $database->bind(':first_name', $first_name);
    $database->execute();
    if ($database->lastInsertId()) {
        echo '<p>Post Added!</p>';
    }
}

$database->query('SELECT * FROM blog_posts');
$rows = $database->resultSet();


$date = new DateTime();

?>
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
    <div id="postModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Post</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                        <label>Post Name</label><br />
                        <input type="text" name="first_name" placeholder="Add First Name"/><br /><br />
                        <label>Post Title</label><br />
                        <input type="text" name="title" placeholder="Add a Title..." /><br /><br />
                        <label>Post Body</label><br />
                        <textarea name="body"></textarea><br /><br />
                        <input type="submit" name="submit" value="Submit" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="jumbotron">
        <h1 class="display-3" style="text-align: center;">Base Design</h1>
        <p style="text-align: center">Frame for Client Demo</p>
    </div>
        <div class="container">
            <h1>Posts</h1>
            <a style="width: 100px;" type="button" class="btn btn-primary btn-block" data-placement="bottom" id="postButton">Add Post</a>
            <br/>
            <div class="container" style="border: 1px;">
                    <div class="row row-container">
                        <?php foreach($rows as $row) : ?>
                        <div class="col-sm-4">
                            <p style="font-size: 20px; margin-bottom: 0;"><strong><?php echo $row['title'];?></strong></p>
                            <p style="max-width: 100px;"><?php echo $row['post']; ?></p>
                            <p>Posted on: <?php echo $date->format('m/d/Y');?></p>
                            <br/>
                            <form method="post" action="<?php $_SERVER['PHP_SELF']?>">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>"/>
                                <input type="submit" name="delete" value="Delete" />
                            </form>
                            <br/>
                        </div>
                        <?php endforeach; ?>
                    </div>

            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        </div>
    <script>
        $("#postButton").click(function() {
            $("#postModal").modal('show');
        });
    </script>
    </body>
</html>
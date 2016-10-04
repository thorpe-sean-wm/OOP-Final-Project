<?php
require_once('Database.php');

class Tags extends Database {
    public function resultSet(){
        $posts = parent::resultSet();

        if(is_array($posts) && count($posts)) {
            foreach ($posts as &$post) {
                $tags = [];

                $sql = 'SELECT
                          t.name
                        FROM
                          blog_post_tags bpt
                        LEFT JOIN
                          tags t
                        ON
                          bpt.tag_id = t.id
                        WHERE
                          bpt.blog_post_id = :blogid
                        ';
                parent::query($sql);
                parent::bind(':blogid', $post['id']);
                $blogTags = parent::resultSet();

                foreach ($blogTags as $btag) {
                    array_push($tags, $btag['name']);
                }

                $post['tags'] = implode(', ', $tags);
            }
            return $posts;
        }else{
            return [];
        }
    }
}





?>
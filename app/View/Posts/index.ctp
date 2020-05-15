<!-- File: /app/View/Posts/index.ctp -->

<h1>Blog posts</h1>
<p><?php echo $this->Html->link('Add Post', array('action' => 'add')); ?></p>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Actions</th>
        <th>Created</th>
    </tr>

<!-- ここで $posts 配列をループして、投稿情報を表示 -->

    <?php foreach ($posts as $post): ?>//コントローラからもらったデータをそれぞれ表示する
    <tr>
        <td><?php echo $post['Post']['id']; ?></td>
        <td>
            <?php
                echo $this->Html->link(
                    $post['Post']['title'],
                    array('action' => 'view', $post['Post']['id'])
                );
            ?>
        </td>
        <td>
            <?php
                echo $this->Form->postLink(//Postリクエストをするためのjavascriptを使うリンクが生成される。
                    'Delete',//削除のリンクを表示
                    array('action' => 'delete', $post['Post']['id']),
                    array('confirm' => 'Are you sure?')//確認
                );
            ?>
            <?php
                echo $this->Html->link(//編集のリンクを表示
                    'Edit', array('action' => 'edit', $post['Post']['id'])
                );
            ?>
        </td>
        <td>
            <?php echo $post['Post']['created']; ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>
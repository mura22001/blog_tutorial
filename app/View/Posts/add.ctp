<!-- File: /app/View/Posts/add.ctp -->

<h1>Add Post</h1>
<?php
echo $this->Form->create('Post');//Postで送る
echo $this->Form->input('title');//titleでテキストボックス
echo $this->Form->input('body', array('rows' => '3'));//bodyでテキストボックス3行
echo $this->Form->end('Save Post');//ボタンでsavePostと書いてある。
?>
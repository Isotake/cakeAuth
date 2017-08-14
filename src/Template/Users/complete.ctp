<div class="completePage">
    <div class="complete_message">
      <h1 class="complete_txt"><?= __('会員登録が完了しました') ?></h1>
      <p class="complete_subtxt"><?= __('ご登録頂いたユーザIDとパスワードでログインしてください。') ?></p>
    </div>
    <div class="completePage-inner">
      <div class="complete_img">
        <img src="/images/user_complete.png" alt="">
      </div>
    <?= $this->Form->create() ?>

    <fieldset>
        <legend><?= __('ログイン') ?></legend>
        <?= $this->Form->input('username') ?>
        <?= $this->Form->input('password') ?>

        <div class="mb5 clearfix">
            <?= $this->Form->input('autologin', ['type' => 'checkbox', 'default' => true, 'label' => '保存する']) ?>

            <button type="submit" class="btn btn-primary pull-right">
                <i class ="glyphicon glyphicon-log-in"></i> ログイン
            </button>
        </div>
    </fieldset>
    <div class="forgetPass">
        <a href="http://www.bigweb.co.jp/index.php?ph=user_forget">※パスワードを忘れた方はこちら</a>
    </div>
    <?= $this->Form->end() ?>

  </div>
</div>


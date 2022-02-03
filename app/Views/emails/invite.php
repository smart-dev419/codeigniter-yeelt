<p>
    <?= $_SESSION['userData']['FirstName']; ?> (<?= $_SESSION['userData']['Email']; ?>) has invited you to join the Yeelt workspace: '<?= $seller['Name']; ?>'. Join now to start collaborating! Please approve or reject the request by this seller below.
</p>
<p>
    <a href="<?= $invite_link_accept; ?>">Approve</a> | <a href="<?= $invite_link_reject; ?>">Reject</a> 
</p>
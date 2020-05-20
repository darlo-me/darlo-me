<?php
$urls = [
    'darlome' => 'https://github.com/darlo-me/darlo-me',
    'php2static' => 'https://github.com/darlo-me/php2static',
];
?>

<h1>My software:</h1>
    <details>
        <summary>Libraries</summary>
        <details>
            <summary>php2static - <a href='<?php echo $urls['php2static']; ?>'><?php echo $urls['php2static']; ?></a></summary>
            <p>Small library to enable view-controller and inter-view/inter-controller communication.</p>
            <p>Allows easy code reuse by using php as a templating engine and sending variables via a $this object</p>
            <p>View the README or look at the <a href='<?php echo $urls['darlome']; ?> '>code</a> for this website for an example usage.</p>
        </details>
    </details>
</ul>

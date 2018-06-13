<rss version="2.0">
    <channel>
        <title>
        <?php echo $title?>
        </title>
        <description>
        <?php echo $description?>
        </description>
        <link><?php echo $link?></link>
        <copyright>muonnha.com.vn</copyright>
        <generator>muonnha.com.vn</generator>
        <pubDate><?php echo date("Y-m-d H:i:s", time())?></pubDate>
        <lastBuildData><?php echo date("Y-m-d H:i:s", time())?></lastBuildData>
        <?php foreach($results as $item) : ?>
        <item>
            <title>
            <![CDATA[
                <?php echo $item['title']?>
            ]]>
            </title>
            <description>
                <![CDATA[
                <?php echo $item['description']?>
            ]]>
            </description>
            <link><?php echo site_url($item['alias'])?></link>
            <pubDate><?php echo $item['create_time']?></pubDate>
        </item>
        <?php endforeach; ?>
    </channel>
</rss>
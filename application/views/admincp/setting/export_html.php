<style>
table{
    border-collapse: collapse;
    border-left: 1px solid #222;
    border-top: 1px solid #222;
}
table tr th, table tr td{
    border-bottom: 1px solid #222;
    border-right: 1px solid #222;
}
</style>
<table class="table">
    <thead>
        <tr>
            <th>Tiêu đề</th>
            <th>Alias</th>
            <th>Tỉnh thành</th>
            <th>Quận huyện</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($results as $item) : ?>
    <tr>
        <td><?=$item['title']?></td>
        <td><?=$item['alias']?></td>
        <td><?=$item['city_id']?></td>
        <td><?=$item['district_id']?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
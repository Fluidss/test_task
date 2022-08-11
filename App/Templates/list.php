<?php
function sort_link_th($title, $a, $b)
{
    $sort = @$_GET['sort'];

    if ($sort == $a) {
        return '<a class="active" href="?sort=' . $b . '">' . $title . ' <i>▲</i></a>';
    } elseif ($sort == $b) {
        return '<a class="active" href="?sort=' . $a . '">' . $title . ' <i>▼</i></a>';
    } else {
        return '<a href="?sort=' . $a . '">' . $title . '</a>';
    }
}

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список студентов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            gap: 20px
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo sort_link_th('Имя', 'name_asc', 'name_desc'); ?></th>
                        <th><?php echo sort_link_th('Фамилия', 'surname_asc', 'surname_desc'); ?></th>
                        <th><?php echo sort_link_th('Группа', 'group_asc', 'group_desc'); ?></th>
                        <th><?php echo sort_link_th('Баллы', 'point_asc', 'point_desc'); ?></th>
                        <th><?php echo sort_link_th('Пол', 'gender_asc', 'gender_desc'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student) : ?>
                        <tr>
                            <td><?= $student['name'] ?></td>
                            <td><?= $student['surname'] ?></td>
                            <td><?= $student['group'] ?></td>
                            <td><?= $student['point'] ?></td>
                            <td><?= $student['gender'] ?></td>
                        </tr>

                    <? endforeach; ?>
                </tbody>
            </table>
            <ul class="pagination">
                <?
                for ($i = 1; $i <= $params['pagination']; $i++) {
                    if ($i == $params['page']) {
                        $paginationClass = 'pagination-active';
                        echo "<li><a class=\"{$paginationClass}\" href=\"?page={$i}\">$i</a></li>";
                    } else {
                        echo "<li><a href=\"?page={$i}\">$i</a></li>";
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <a href="/">Добавить студента</a>
</body>

</html>
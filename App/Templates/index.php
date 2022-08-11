<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить студента</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .input_error input {
            border-color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <form action='add' method="post">
                <div class="form-group mt-2 <? if (isset($_SESSION['errors']['email'])) echo 'input_error'; ?>">
                    <input type="text" value="<? if (isset($data['email'])) echo trim($data['email']); ?>" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Почта" required>
                </div>
                <div class="form-group mt-2 <? if (isset($_SESSION['errors']['name'])) echo 'input_error'; ?>">
                    <input type="text" value="<? if (isset($data['name'])) echo trim($data['name']); ?>" name="name" class="form-control" id="exampleInputname" placeholder="Имя" required>
                </div>
                <div class="form-group mt-2 <? if (isset($_SESSION['errors']['surname'])) echo 'input_error'; ?>">
                    <input type="text" value="<? if (isset($data['surname'])) echo trim($data['surname']); ?>" name="surname" class="form-control" id="exampleInputname" placeholder="Фамилия" required>
                </div>
                <div class="form-group mt-2 <? if (isset($_SESSION['errors']['group'])) echo 'input_error'; ?>">
                    <input type="text" value="<? if (isset($data['group'])) echo trim($data['group']); ?>" name="group" class="form-control" id="exampleInputname" placeholder="Группа" required>
                </div>
                <div class="form-group mt-2 <? if (isset($_SESSION['errors']['points'])) echo 'input_error'; ?>">
                    <input type="number" value="<? if (isset($data['points'])) echo trim($data['points']); ?>" name="points" class="form-control" id="exampleInputname" placeholder="Баллы" required>
                </div>
                <select class="form-select mt-2" aria-label="Default select example">
                    <?
                    for ($i = 1985; $i < date('Y'); $i++) : ?>
                        <option value="<?= $i ?>">
                            <?= $i ?>
                        </option>
                    <? endfor; ?>
                </select>
                <div class="form-check  mt-2">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="man" checked>
                    <label class="form-check-label" for="inlineRadio1">Муж</label>
                </div>
                <div class="form-check  mt-2">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="girl">
                    <label class="form-check-label" for="inlineRadio2">Жен</label>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Добавить</button>
            </form>
            <?php
            if (isset($_SESSION['errors'])) :
                foreach ($_SESSION['errors'] as $error) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $error ?>
                    </div>
                <? endforeach;
                unset($_SESSION['errors']);
            endif;
            if (isset($_SESSION['success'])) : ?>
                <div class="alert alert-success" role="alert">
                    <?= $_SESSION['success'] ?>
                </div>
            <? unset($_SESSION['success']);
            endif; ?>
        </div>
    </div>
    <a href="list">Список студентов</a>
</body>

</html>
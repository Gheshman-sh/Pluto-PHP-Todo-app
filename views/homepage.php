<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body data-bs-theme="dark">
    <nav class="navbar bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand fs-3 fw-medium text-center" href="/">Todo App</a>
        </div>
    </nav>

    <div class="container my-4 rounded py-4 border">
        <h2 class="mb-3">Add todo list</h2>
        <form action="/" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Enter the todo title</label>
                <input type="text" class="form-control" name="title" id="title" required>
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Enter the todo description</label>
                <textarea name="desc" id="desc" class="form-control" required></textarea>
            </div>
            <?php set_csrf(); ?>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>

    <?php foreach ($todoItems as $item) : ?>
        <div class="container border rounded my-4 p-3">
            <h2><?= $item['title'] ?></h2>
            <p><?= $item['description'] ?></p>
            <p><?= $item['date'] ?></p>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal<?= $item['id'] ?>">Update</button>
                <form action="/delete" method="POST" style="display: inline;">
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                    <?php set_csrf(); ?>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>

            <div class="modal fade" id="updateModal<?= $item['id'] ?>" tabindex="-1" aria-labelledby="updateModalLabel<?= $item['id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateModalLabel<?= $item['id'] ?>">Update Todo Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/update" method="POST">
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                <div class="mb-3">
                                    <label for="title<?= $item['id'] ?>" class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" id="title<?= $item['id'] ?>" value="<?= $item['title'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="desc<?= $item['id'] ?>" class="form-label">Description</label>
                                    <textarea name="desc" id="desc<?= $item['id'] ?>" class="form-control" required><?= $item['description'] ?></textarea>
                                </div>
                                <?php set_csrf(); ?>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
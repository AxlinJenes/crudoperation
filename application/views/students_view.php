<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Student Manager</h2>
        <button id="addStudentBtn" class="btn btn-success">+ Add Student</button>
    </div>

    <!-- Student Modal -->
    <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="studentForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Add / Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="studentId">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" id="age" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3" id="passwordGroup">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control">
                        <div class="form-text">Leave blank to keep current password.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Students Table -->
    <table id="studentsTable" class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr><th>ID</th><th>Name</th><th>Age</th><th>Email</th><th>Actions</th></tr>
        </thead>
        <tbody></tbody>
    </table>
    <a href="<?= base_url('index.php/auth/logout') ?>" class="btn btn-danger">Logout</a>
</div>

<script>
let dataTable;
const modal = new bootstrap.Modal(document.getElementById('studentModal'));

function fetchStudents() {
    $.post("<?= base_url('index.php/StudentController/handleRequest') ?>", { action: 'read' }, function (data) {
        dataTable.clear();
        data.forEach(s => {
            dataTable.row.add([
                s.StudentsID,
                s.Name,
                s.Age,
                s.Email,
                `<button class="btn btn-sm btn-warning editBtn" 
                    data-id="${s.StudentsID}" 
                    data-name="${s.Name}" 
                    data-age="${s.Age}" 
                    data-email="${s.Email}">Edit</button>
                 <button class="btn btn-sm btn-danger deleteBtn" data-id="${s.StudentsID}">Delete</button>`
            ]);
        });
        dataTable.draw();
    }, 'json');
}

$(function () {
    dataTable = $('#studentsTable').DataTable();
    fetchStudents();

    $('#addStudentBtn').click(function () {
        $('#studentForm')[0].reset();
        $('#studentId').val('');
        $('#studentModalLabel').text('Add Student');
        $('#passwordGroup').show();
        modal.show();
    });

    $('#studentForm').submit(function (e) {
        e.preventDefault();
        const id = $('#studentId').val();
        const action = id ? 'update' : 'create';

        $.post("<?= base_url('index.php/StudentController/handleRequest') ?>", {
            action,
            id,
            name: $('#name').val(),
            age: $('#age').val(),
            email: $('#email').val(),
            password: $('#password').val()
        }, function (res) {
            alert(res);
            modal.hide();
            fetchStudents();
        });
    });

    $(document).on('click', '.editBtn', function () {
        $('#studentId').val($(this).data('id'));
        $('#name').val($(this).data('name'));
        $('#age').val($(this).data('age'));
        $('#email').val($(this).data('email'));
        $('#password').val('');
        $('#studentModalLabel').text('Edit Student');
        $('#passwordGroup').hide();
        modal.show();
    });

    $(document).on('click', '.deleteBtn', function () {
        const id = $(this).data('id');
        if (confirm("Delete this student?")) {
            $.post("<?= base_url('index.php/StudentController/handleRequest') ?>", { action: 'delete', id }, function (res) {
                alert(res);
                fetchStudents();
            });
        }
    });

    $('#studentModal').on('hidden.bs.modal', function () {
        $('#studentForm')[0].reset();
        $('#studentId').val('');
        $('#passwordGroup').show();
        $('#studentModalLabel').text('Add / Edit Student');
    });
});
</script>

</body>
</html>

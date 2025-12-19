<?php
// api/ApiService.php

require_once __DIR__ . '/../config/config.php';

class StudentService {
    
    public static function getAll($page = null, $size = null) {
        $params = [];
        if ($page !== null) $params['page'] = $page;
        if ($size !== null) $params['size'] = $size;
        
        return callAPI('GET', '/students', $params);
    }
    
    public static function getById($id) {
        return callAPI('GET', "/students/$id");
    }
    
    public static function getByNim($nim) {
        return callAPI('GET', "/students/nim/$nim");
    }
    
    public static function search($keyword) {
        return callAPI('GET', '/students/search', ['q' => $keyword]);
    }
    
    public static function create($data) {
        return callAPI('POST', '/students', $data);
    }
    
    public static function update($id, $data) {
        return callAPI('PUT', "/students/$id", $data);
    }
    
    public static function delete($id) {
        return callAPI('DELETE', "/students/$id");
    }
}

class EquipmentService {
    
    public static function getAll($page = null, $size = null) {
        $params = [];
        if ($page !== null) $params['page'] = $page;
        if ($size !== null) $params['size'] = $size;
        
        return callAPI('GET', '/equipments', $params);
    }
    
    public static function getById($id) {
        return callAPI('GET', "/equipments/$id");
    }
    
    public static function search($keyword) {
        return callAPI('GET', '/equipments/search', ['q' => $keyword]);
    }
    
    public static function getByCategory($categoryId) {
        return callAPI('GET', "/equipments/category/$categoryId");
    }
    
    public static function getByCondition($status) {
        return callAPI('GET', "/equipments/condition/$status");
    }
    
    public static function create($data) {
        return callAPI('POST', '/equipments', $data);
    }
    
    public static function update($id, $data) {
        return callAPI('PUT', "/equipments/$id", $data);
    }
    
    public static function delete($id) {
        return callAPI('DELETE', "/equipments/$id");
    }
}

class TransactionService {
    
    public static function getAll($page = null, $size = null) {
        $params = [];
        if ($page !== null) $params['page'] = $page;
        if ($size !== null) $params['size'] = $size;
        
        return callAPI('GET', '/transactions', $params);
    }
    
    public static function getById($id) {
        return callAPI('GET', "/transactions/$id");
    }
    
    public static function getActiveBorrowings() {
        return callAPI('GET', '/transactions/active-borrowings');
    }
    
    public static function getStudentHistory($studentId) {
        return callAPI('GET', "/transactions/student-history/$studentId");
    }
    
    public static function create($data) {
        return callAPI('POST', '/transactions', $data);
    }
    
    public static function update($id, $data) {
        return callAPI('PUT', "/transactions/$id", $data);
    }
    
    public static function delete($id) {
        return callAPI('DELETE', "/transactions/$id");
    }
}

class CategoryService {
    
    public static function getAll() {
        return callAPI('GET', '/categories');
    }
    
    public static function getById($id) {
        return callAPI('GET', "/categories/$id");
    }
    
    public static function search($keyword) {
        return callAPI('GET', '/categories/search', ['q' => $keyword]);
    }
    
    public static function create($data) {
        return callAPI('POST', '/categories', $data);
    }
    
    public static function update($id, $data) {
        return callAPI('PUT', "/categories/$id", $data);
    }
    
    public static function delete($id) {
        return callAPI('DELETE', "/categories/$id");
    }
}

class UserService {
    
    public static function getAll() {
        return callAPI('GET', '/users');
    }
    
    public static function getById($id) {
        return callAPI('GET', "/users/$id");
    }
    
    public static function getByRole($role) {
        return callAPI('GET', "/users/role/$role");
    }
    
    public static function create($data) {
        return callAPI('POST', '/users', $data);
    }
    
    public static function update($id, $data) {
        return callAPI('PUT', "/users/$id", $data);
    }
    
    public static function delete($id) {
        return callAPI('DELETE', "/users/$id");
    }
}
?>
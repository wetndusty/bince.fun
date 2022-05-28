<?php

include "dbh.php";

function sql_insert($tname, $sql_fields_list) {
    global $dbh;
    $sql = "insert into " . $tname . " (" . implode(", ", array_keys($sql_fields_list))
            . ")  values ('" . implode("', '", array_values($sql_fields_list)) . "')";
    //echo $sql;
    $dbh->exec($sql);
}

function sql_get_table($tname, $fields = ['*'], $filter = []) {
    global $dbh;
    $sql = 'select ' . implode(", ", $fields) . ' from ' . $tname . sql_where($filter);
    $sth = $dbh->query($sql);
    return $sth->fetchAll($mode = PDO::FETCH_ASSOC);
}

function sql_get_table_fx($tname, $sql_fields, $where_list) {
    global $dbh;
    $where = sql_get_pairs($where_list, " and ");
    $sql = 'select ' . implode(", ", $sql_fields) . ' from '
            . $tname . ' where ' . $where;
    echo $sql;
    $sth = $dbh->query($sql);
    return $sth->fetchAll($mode = PDO::FETCH_ASSOC);
}

;

function sql_update($tname, $assign_list, $where_list) {
    global $dbh;
    $sql = "update " . $tname . " set " . sql_get_pairs($assign_list, ", ")
            . " where " . sql_get_pairs($where_list, ' and ');
    //return $sql;
    $dbh->exec($sql);
}

function sql_get_pairs($list, $delimeter) {
    $fun = fn($key, $value) => $key . "='" . $value . "'";
    return implode($delimeter, array_map($fun, array_keys($list), $list));
}

function sql_where($filter) {
    return $filter ? (' where ' . sql_get_pairs($filter, ' and ')) : '';
}

function sql_stored_proc(PDOStatement $ps) {
    $ps->execute();
    $out_arr = [];
    do {
        $s = $ps->fetchAll($mode = PDO::FETCH_ASSOC);
        if ($s) {
            $out_arr[] = $s;
        }
    } while ($ps->nextRowset());
    return $out_arr;
}

function pure_sql($sql) {
    global $dbh;
    $sth = $dbh->query($sql);
    $out_arr = [];
    do {
        $s = $sth->fetchAll($mode = PDO::FETCH_ASSOC);
        if ($s) {
            $out_arr[] = $s;
        }
    } while ($sth->nextRowset());
    return $out_arr;
}

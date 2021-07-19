INSERT INTO directory (
    dir_id,
    dir_parentid,
    dir_name,
    dir_file_num,
    dir_acu_path,
    dir_create_time
  )
VALUES (
    1,
    0,
    "books",
    0,
    "../uploads/",
    now()
  );
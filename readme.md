用法：  
将contestinfo-default.php中内容修改
并改名为contestinfo.php
执行structure.sql以新建数据表
在uploadprocess.php和readcode.php中修改试题保留目录
1.（重要）：每次考试开始之前，请清空试题保存目录（例如，对于默认路径，只保留到users）  
2.（不太重要，但建议，否则会造成选手迷惑）：清空 TOIsubmissions数据表
3.（需要）：编辑contestinfo.php文件
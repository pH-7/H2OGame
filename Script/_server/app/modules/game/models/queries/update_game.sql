UPDATE [DB_PREFIX]Game SET categoryId = :category_id, name = :name, title = :title, description = :description, keywords = :keywords WHERE gameId = :game_id LIMIT 1;

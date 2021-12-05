DROP TABLE IF EXISTS storage_places;

-- 儲存地點
CREATE TABLE storage_places (
    id VARCHAR(20),
    name VARCHAR(20) UNIQUE,
    type VARCHAR(20),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS comic_authors;

-- 漫畫作者
CREATE TABLE comic_authors(
    id VARCHAR(20),
    name VARCHAR(20) UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS comic;

-- 漫畫
CREATE TABLE comic(
    id VARCHAR(20),
    author_id VARCHAR(20),
    place_id VARCHAR(20),
    name VARCHAR(20) UNIQUE,
    size VARCHAR(15),
    location TEXT,
    backed_up BOOLEAN,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS video_actresses;

-- 影片女主角
CREATE TABLE video_actresses(
    id VARCHAR(20),
    name VARCHAR(20) UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS video;

-- 影片
CREATE TABLE video(
    id VARCHAR(20),
    actress_id VARCHAR(20),
    place_id VARCHAR(20),
    name VARCHAR(20) UNIQUE,
    size VARCHAR(15),
    location TEXT,
    backed_up BOOLEAN,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP
);
-- SONG #1 - "WHOLEHEARTEDLY"

DELETE
FROM songs
WHERE name = 'Всім серцем';

INSERT INTO songs (id, name, slug, author, type, image, original_key, bpm, time_signature, audio, meta_title,
                   meta_description, meta_image, created_at, updated_at)
VALUES ('01jy0vqz3fk4f9g07dcwp6xsjf',
        'Всім серцем',
        'wholeheartedly',
        'NC-WORSHIP',
        'authors',
        NULL,
        'D',
        132,
        '4/4',
        NULL,
        'Всім серцем',
        NULL,
        NULL,
        NOW(),
        NOW());

DELETE
FROM song_sections
WHERE id IN ('01jy0wjjg1n04mzwyw6wm1eqk9', '01jy19pdaexbs3fv7wexmsrp9c',
             '01jy19z7bdmaj85pdv8bvw6hhx');

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy0wjjg1n04mzwyw6wm1eqk9',
        'verse',
        1,
        E'Ісус, Ти - скарб мій\nІсус Незрівнянний\nДля Тебе моє життя\nТобі служу я',
        E'D A/C#\n Hm G\n' ||
        E'D A/C#\n Hm G',
        '01jy0vqz3fk4f9g07dcwp6xsjf',
        NOW(),
        NOW());
INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy19pdaexbs3fv7wexmsrp9c',
        'chorus',
        2,
        E'Всім серцем, душею, всім розумом і силою\nТебе люблю!\n' ||
        E'Не змовкнуть ніколи слова моїn\nСкажу: "Тебе люблю"',
        E'D A/C#\n Hm G\n' ||
        E'D A/C#\n Hm G',
        '01jy0vqz3fk4f9g07dcwp6xsjf',
        NOW(),
        NOW());
INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy19z7bdmaj85pdv8bvw6hhx',
        'bridge',
        3,
        E'Перш за все Тебе я прагну,\nБог, Тебе шукаю!\nТи - скарб мого життя!\n' ||
        E'Всі турботи до Твоїх ніг,\nБоже, покладаю\nШукаю Царства я!',
        E'Hm F#m\nG\nA\n' ||
        E'Hm F#m\nG\nA',
        '01jy0vqz3fk4f9g07dcwp6xsjf',
        NOW(),
        NOW());


-- SONG #2 - "ЗНОВУ І ЗНОВУ"

DELETE
FROM songs
WHERE name = 'Знову і знову';

INSERT INTO songs (id, name, slug, author, type, image, original_key, bpm, time_signature, audio, meta_title,
                   meta_description, meta_image, created_at, updated_at)
VALUES ('01jy1ca4hggpeczxhkf9t5wa6y',
        'Знову і знову',
        'znovu-i-znovu',
        'Elevation Rhythm',
        'translated',
        NULL,
        'D',
        69,
        '6/8',
        NULL,
        'Знову і знову',
        NULL,
        NULL,
        NOW(),
        NOW());

DELETE
FROM song_sections
WHERE id IN ('01jy1cbf1d1h0tckjvv6rnbepd', '01jy1cbnc95r5cnzrwy96v5r63', '01jy1cbwjh7x3kmwj86vh836cs',
             '01jy1cc9ms9tvjcjydj05j69w2');

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1cbf1d1h0tckjvv6rnbepd',
        'verse1',
        1,
        E'Святий - це Той, Хто Ти є\nТворіння співає усе:\n"Слава!"\nБо сила є вся в Тобі\nСила лише в Тобі!',
        E'G\n D\nG\nD\nD/F#',
        '01jy1ca4hggpeczxhkf9t5wa6y',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1cbnc95r5cnzrwy96v5r63',
        'chorus',
        2,
        E'Я ніколи не спинюсь\nСпівати: "Ти Гідний!"\n\nПрагну славу віддати\nЖиттям всім Тобі, Бог\nЗнову і знову, мій Бог',
        E'G\nG\nHm\nD/F#\nD A G',
        '01jy1ca4hggpeczxhkf9t5wa6y',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1cbwjh7x3kmwj86vh836cs',
        'verse2',
        3,
        E'Завжди\nЙ навіки Ти є Незрівнянний\nВ славі Небес вічно сяєш!\nПодібних нема Тобі,\nПодібних нема',
        E'G\n D\nG\nD\nD/F#',
        '01jy1ca4hggpeczxhkf9t5wa6y',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1cc9ms9tvjcjydj05j69w2',
        'bridge',
        4,
        E'Співаймо: "Святий! Святий!"\nТобі, Господь Єдиний!\nХто є, як Ти?\n\nВ поклонінні вічнім\nМи серця схиляєм!\nНема таких, як Ти!',
        E'G\n D/F#\nHm A\nG\n D/F#\nHm A',
        '01jy1ca4hggpeczxhkf9t5wa6y',
        NOW(),
        NOW());

-- SONG #3 - "НАД УСІМ Є ТИ"

DELETE
FROM songs
WHERE name = 'Над усім є Ти';

INSERT INTO songs (id, name, slug, author, type, image, original_key, bpm, time_signature, audio, meta_title,
                   meta_description, meta_image, created_at, updated_at)
VALUES ('01jy1cd0k9p7m2x3n4q5r6t7u8',
        'Над усім є Ти',
        'nad-usim-ie-ty',
        'NC-WORSHIP',
        'authors',
        NULL,
        'G',
        120,
        '4/4',
        NULL,
        'Над усім є Ти',
        NULL,
        NULL,
        NOW(),
        NOW());

DELETE
FROM song_sections
WHERE id IN ('01jy1cd1l0q8n3x4m5r6t7u8v9', '01jy1cd2m1r9o4y5n6u7t8v9w0', '01jy1cd3n2s0p5z6o7v8t9w0x1');

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1cd1l0q8n3x4m5r6t7u8v9',
        'verse',
        1,
        E'Люблю тебе, Господи, сило моя,\nНадійна опора і скеля міцна!\nХто як не ти, Господь, мій Захисник,\nВічне спасіння від всіх ворогів?',
        E'D\nD/C\nG\nG/H',
        '01jy1cd0k9p7m2x3n4q5r6t7u8',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1cd2m1r9o4y5n6u7t8v9w0',
        'chorus',
        2,
        E'Ти є живий Господь, звеличений!\nНема подібного Царю Царів!\nТи є радість моя у час складний,\nО могутній Бог, над усім є Ти!',
        E'D\nD/C\nG\nG/H',
        '01jy1cd0k9p7m2x3n4q5r6t7u8',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1cd3n2s0p5z6o7v8t9w0x1',
        'bridge',
        3,
        E'Підійму я руки догори,\nЗ хвалою йду в обійми я Твої!\nВ моїй тісноті, вкриваюсь в Тобі,\nО могутній Бог, над усім є Ти!',
        E'D\nD/C\nG\nG/H',
        '01jy1cd0k9p7m2x3n4q5r6t7u8',
        NOW(),
        NOW());

-- SONG #4 - "ТАНЦЮЙ"

DELETE
FROM songs
WHERE name = 'Танцюй';

INSERT INTO songs (id, name, slug, author, type, image, original_key, bpm, time_signature, audio, meta_title,
                   meta_description, meta_image, created_at, updated_at)
VALUES ('01jy1ce0l1q8n3x4m5r6t7u8v9',
        'Танцюй',
        'tanciuj',
        'Jesus Culture',
        'authors',
        NULL,
        'E',
        135,
        '4/4',
        NULL,
        'Танцюй',
        NULL,
        NULL,
        NOW(),
        NOW());

DELETE
FROM song_sections
WHERE id IN ('01jy1ce1m2r9o4y5n6u7t8v9w0', '01jy1ce2n3s0p5z6o7v8t9w0x1', '01jy1ce3o4t1q6a7p8w9x0y1z2',
             '01jy1ce4p5u2r7b8q9x1y2z3a4');

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1ce1m2r9o4y5n6u7t8v9w0',
        'verse',
        1,
        E'Я в серці Твоїм , Мій Бог , Назавжди\nТвоя я любов вічна\nТебе я прославлю\nЗнаю ніщо не зупинить ніколи мене',
        E'C#m\nA2\nH\nF#m\nC#m\nA2\nH\nF#m',
        '01jy1ce0l1q8n3x4m5r6t7u8v9',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1ce2n3s0p5z6o7v8t9w0x1',
        'verse',
        2,
        E'Близько завжди Ти, мій Господь\nВ славі і хвалі живеш\nТебе я прославлю\nЗнаю ніщо не зупинить ніколи мене',
        E'C#m\nA2\nH\nF#m\nC#m\nA2\nH\nF#m',
        '01jy1ce0l1q8n3x4m5r6t7u8v9',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1ce3o4t1q6a7p8w9x0y1z2',
        'chorus',
        3,
        E'Танцюй , Танцюй\nДух святий в мені Танцюй',
        E'C#m\nA2\nH\nF#m\nC#m\nA2',
        '01jy1ce0l1q8n3x4m5r6t7u8v9',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1ce4p5u2r7b8q9x1y2z3a4',
        'bridge',
        4,
        E'Ти зі мною назавжди мій Господь\nВ Тобі життя моє\nСлавлю я Тебе',
        E'C#m\nA2\nH\nF#m\nC#m\nA2\nH',
        '01jy1ce0l1q8n3x4m5r6t7u8v9',
        NOW(),
        NOW());

-- SONG #5 - "СПІВАЮ АЛІЛУЯ"

DELETE
FROM songs
WHERE name = 'Співаю Алілуя';

INSERT INTO songs (id, name, slug, author, type, image, original_key, bpm, time_signature, audio, meta_title,
                   meta_description, meta_image, created_at, updated_at)
VALUES ('01jy1cf0m2s0p5z6o7v8t9w0x1',
        'Співаю Алілуя',
        'spivaju-aliluja',
        'Bethel Music',
        'translated',
        NULL,
        'C#',
        82,
        '4/4',
        NULL,
        'Співаю Алілуя',
        NULL,
        NULL,
        NOW(),
        NOW());

DELETE
FROM song_sections
WHERE id IN ('01jy1cf1n3t1q6a7p8w9x0y1z2', '01jy1cf2o4u2r7b8q9x1y2z3a4', '01jy1cf3p5v3s8c9r0y1z2a3b4');

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1cf1n3t1q6a7p8w9x0y1z2',
        'verse',
        1,
        E'Співаю: "Алілуя!"\nВ присутності всіх ворогів\nСпіваю: "Алілуя!"\nГучніше усіх сумнівів',
        E'C#\nG#\nA#m\nF#',
        '01jy1cf0m2s0p5z6o7v8t9w0x1',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1cf2o4u2r7b8q9x1y2z3a4',
        'verse',
        2,
        E'Співаю: "Алілуя!"\nМій меч - моя мелодія\nСпіваю: "Алілуя!"\nНебеса - броня моя',
        E'C#\nG#\nA#m\nF#',
        '01jy1cf0m2s0p5z6o7v8t9w0x1',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1cf3p5v3s8c9r0y1z2a3b4',
        'chorus',
        3,
        E'Буду співати, коли навіть штормить!\nВище і вище Я підіймаю голос свій!\nВстане надія: з руїн оживе\nСмерті нема вже, бо Цар мій живе!',
        E'F#\nC#\nA#m\nG#',
        '01jy1cf0m2s0p5z6o7v8t9w0x1',
        NOW(),
        NOW());

-- SONG #6 - "ВЕЛИКИЙ НАШ БОГ"

DELETE
FROM songs
WHERE name = 'Великий наш Бог';

INSERT INTO songs (id, name, slug, author, type, image, original_key, bpm, time_signature, audio, meta_title,
                   meta_description, meta_image, created_at, updated_at)
VALUES ('01jy1cg0n4t1q6a7p8w9x0y1z2',
        'Великий наш Бог',
        'velykyi-nash-boh',
        'Chris Tomlin',
        'translated',
        NULL,
        'A',
        78,
        '4/4',
        NULL,
        'Великий наш Бог',
        NULL,
        NULL,
        NOW(),
        NOW());

DELETE
FROM song_sections
WHERE id IN ('01jy1cg1o5u2r7b8q9x1y2z3a4', '01jy1cg2p6v3s8c9r0y1z2a3b4');

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1cg1o5u2r7b8q9x1y2z3a4',
        'verse',
        1,
        E'Могутній, славний Цар, величний у красі!\nРадіє вся земля,\nРадіє вся земля!\nУ Ньому світла блиск і темряви нема\nА голос, наче грім,\nА голос, наче грім!',
        E'G\nEm\nC\nG\nEm\nC',
        '01jy1cg0n4t1q6a7p8w9x0y1z2',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1cg2p6v3s8c9r0y1z2a3b4',
        'chorus',
        2,
        E'Великий наш Бог!\nЗаспівай: "Великий наш Бог!"\nПрославляй! Великий,\nВеликий наш Бог!',
        E'G\nEm\nC\nD\nG\nG',
        '01jy1cg0n4t1q6a7p8w9x0y1z2',
        NOW(),
        NOW());

-- SONG #7 - "НЕЙМОВІРНА ЛЮБОВ"

DELETE
FROM songs
WHERE name = 'Неймовірна любов';

INSERT INTO songs (id, name, slug, author, type, image, original_key, bpm, time_signature, audio, meta_title,
                   meta_description, meta_image, created_at, updated_at)
VALUES ('01jy1ch0o6v3s8c9r0y1z2a3b4',
        'Неймовірна любов',
        'neimovirna-ljubov',
        'Cory Asbury',
        'translated',
        NULL,
        'E',
        163,
        '6/8',
        NULL,
        'Неймовірна любов',
        NULL,
        NULL,
        NOW(),
        NOW());

DELETE
FROM song_sections
WHERE id IN ('01jy1ch1p7w4t9d0s1z2a3b4c5', '01jy1ch2q8x5u0e1a2b3c4d5f6', '01jy1ch3r9y6v1f2b3c4d5e6g7');

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1ch1p7w4t9d0s1z2a3b4c5',
        'verse',
        1,
        E'Перш ніж слово сказав,\nТи вже співав мені!\nДо мене Ти добрим був завжди!\n\nПерш ніж подих зробив,\nТи в мене життя вдихнув!\nДо мене Ти Добрим був завжди!',
        E'C#m\nH\nA\nC#m\nH\nA',
        '01jy1ch0o6v3s8c9r0y1z2a3b4',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1ch2q8x5u0e1a2b3c4d5f6',
        'chorus',
        2,
        E'О, ця неймовірна, завжди вірна, Бог, Твоя любов!\nТи залишив дев\'яносто дев\'ять, щоб мене знайти!\nНе можу купити, ні заслужити, цю любов, що Ти даєш!\nО, ця неймовірна, завжди вірна, Бог, Твоя любов!',
        E'C#m\nH\nA\nE\nC#m\nH\nA\nE\nC#m\nH\nA\nE\nC#m\nH\nA\nE',
        '01jy1ch0o6v3s8c9r0y1z2a3b4',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1ch3r9y6v1f2b3c4d5e6g7',
        'bridge',
        3,
        E'Кожну тінь Ти осяєш\nВсі гори здолаєш, щоб мене досягти!\nВсі стіни розіб\'єш,\nБрехню всю розірвеш щоб мене досягти!',
        E'C#m\nH\nA E\nC#m\nH\nA E',
        '01jy1ch0o6v3s8c9r0y1z2a3b4',
        NOW(),
        NOW());

-- SONG #8 - "ПОРЯД"

DELETE
FROM songs
WHERE name = 'Поряд';

INSERT INTO songs (id, name, slug, author, type, image, original_key, bpm, time_signature, audio, meta_title,
                   meta_description, meta_image, created_at, updated_at)
VALUES ('01jy1ci0p8w5u0e1a2b3c4d5f6',
        'Поряд',
        'poriad',
        'Skydoor Worship',
        'general',
        NULL,
        'A',
        70,
        '4/4',
        NULL,
        'Поряд',
        NULL,
        NULL,
        NOW(),
        NOW());

DELETE
FROM song_sections
WHERE id IN ('01jy1ci1q9x6v1f2b3c4d5e6g7', '01jy1ci2r0y7w2g3c4d5e6f7h8', '01jy1ci3s1z8x3h4d5e6f7g8i9');

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1ci1q9x6v1f2b3c4d5e6g7',
        'verse',
        1,
        E'Я побачив, пережив\nЩо реально любиш Ти\nЦе в ранах на руках Твоїх\nХіба ще докази потрібні? Ні!',
        E'A\nF#m\nD\nE',
        '01jy1ci0p8w5u0e1a2b3c4d5f6',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1ci2r0y7w2g3c4d5e6f7h8',
        'chorus',
        2,
        E'Бо любов прекрасна Твоя\nНе осягає розум мій це\nОдин день в Домі Отця\nКраще аніж тисяча не там\nЛюбов завжди поряд, поряд\nЗавжди поряд Бог Твоя',
        E'A\nF#m\nD\nE\nA\nF#m\nD\nE',
        '01jy1ci0p8w5u0e1a2b3c4d5f6',
        NOW(),
        NOW());

INSERT INTO song_sections (id, section_type, "order", lyrics, chords, song_id, created_at, updated_at)
VALUES ('01jy1ci3s1z8x3h4d5e6f7g8i9',
        'bridge',
        3,
        E'Милість Твоя й благодать завжди поряд йде\nКожен час я бачу це',
        E'A F#m\nD E',
        '01jy1ci0p8w5u0e1a2b3c4d5f6',
        NOW(),
        NOW());


-- SETLIST #1 - "WORSHIP NIGHT 2025"

DELETE
FROM set_lists
WHERE name = 'Worship Night 2025';

INSERT INTO set_lists (id, name, band_id, performed_at, created_at, updated_at)
VALUES ('01jy1cj1r0y7w2g3c4d5e6f7h8',
        'Worship Night 2025',
        '01jwbqyrznxxmn0va3nb6f485g',
        '2025-06-20',
        NOW(),
        NOW());

DELETE
FROM set_list_song
WHERE set_list_id = '01jy1cj1r0y7w2g3c4d5e6f7h8';

INSERT INTO set_list_song (id, set_list_id, song_id, number, leader_id, key, pad_id, created_at, updated_at)
VALUES ('01jy1cj3t2a9y4i5j6k7l8m9n0',
        '01jy1cj1r0y7w2g3c4d5e6f7h8',
        '01jy0vqz3fk4f9g07dcwp6xsjf', -- "Всім серцем"
        1,
        '01jxagywmj57rf6cvm13j6ta7t',
        'D',
        '01jwbqhsfxynv7aqdqyszba9b7',
        NOW(),
        NOW());

INSERT INTO set_list_song (id, set_list_id, song_id, number, leader_id, key, pad_id, created_at, updated_at)
VALUES ('01jy1cj4u3b0z5j6k7l8m9n0p1',
        '01jy1cj1r0y7w2g3c4d5e6f7h8',
        '01jy1ca4hggpeczxhkf9t5wa6y', -- "Знову і знову"
        2,
        '01jxff5jn0h8379yp37acghgf5',
        'D',
        '01jwbqhsfxynv7aqdqyszba9b7',
        NOW(),
        NOW());

INSERT INTO set_list_song (id, set_list_id, song_id, number, leader_id, key, pad_id, created_at, updated_at)
VALUES ('01jy1cj5v4c1a6k7l8m9n0p1q2',
        '01jy1cj1r0y7w2g3c4d5e6f7h8',
        '01jy1cd0k9p7m2x3n4q5r6t7u8', -- "Над усім є Ти"
        3,
        '01jwv3g3ebs7vjdv0zttv7y0er',
        'G',
        '01jwbqjjdtyyst8zhfhef8axfk',
        NOW(),
        NOW());

INSERT INTO set_list_song (id, set_list_id, song_id, number, leader_id, key, pad_id, created_at, updated_at)
VALUES ('01jy1cj6w5d2b7l8m9n0p1q2r3',
        '01jy1cj1r0y7w2g3c4d5e6f7h8',
        '01jy1ce0l1q8n3x4m5r6t7u8v9', -- "Танцюй"
        4,
        NULL,
        'E',
        '01jwbq34vbgswxe90nww4n86va',
        NOW(),
        NOW());


-- SETLIST #2 - "МОЛОДІЖКА"

DELETE
FROM set_lists
WHERE name = 'МОЛОДІЖКА';

INSERT INTO set_lists (id, name, band_id, performed_at, created_at, updated_at)
VALUES ('01jy1xec2f031sa7x3gme6w061',
        'МОЛОДІЖКА',
        '01jwbr0k431y2ppqjewvww546m',
        '2025-06-24',
        NOW(),
        NOW());

DELETE
FROM set_list_song
WHERE set_list_id = '01jy1xec2f031sa7x3gme6w061';

INSERT INTO set_list_song (id, set_list_id, song_id, number, leader_id, key, pad_id, created_at, updated_at)
VALUES ('01jy1xjapt6qwt9prfm7exf4bj',
        '01jy1xec2f031sa7x3gme6w061',
        '01jwbtda3hafy2w2m8kjfg0kwm', -- "Waymaker"
        1,
        '01jxff5jn0h8379yp37acghgf5',
        'A',
        '01jwbqjjdtyyst8zhfhef8axfk',
        NOW(),
        NOW());

INSERT INTO set_list_song (id, set_list_id, song_id, number, leader_id, key, pad_id, created_at, updated_at)
VALUES ('01jy1xjvhvfvw0wxccfp3472b3',
        '01jy1xec2f031sa7x3gme6w061',
        '01jwbv7jhmq11gvytb7zzbgd3n', -- "З кожним моїм подихом"
        2,
        NUll,
        'G',
        '01jwbqjjdtyyst8zhfhef8axfk',
        NOW(),
        NOW());

-- SETLIST #3 - "Вечір біля вогнища"

DELETE
FROM set_lists
WHERE name = 'Вечір біля вогнища';

INSERT INTO set_lists (id, name, band_id, performed_at, created_at, updated_at)
VALUES ('01jy1ck1s2a9y4i5j6k7l8m9n0',
        'Вечір біля вогнища',
        '01jvwppqjjwhe7rg31s8we5je3',
        '2025-06-28',
        NOW(),
        NOW());

DELETE
FROM set_list_song
WHERE set_list_id = '01jy1ck1s2a9y4i5j6k7l8m9n0';

INSERT INTO set_list_song (id, set_list_id, song_id, number, leader_id, key, pad_id, created_at, updated_at)
VALUES ('01jy1ck4v5d2b7l8m9n0p1q2r3',
        '01jy1ck1s2a9y4i5j6k7l8m9n0',
        '01jy1ce0l1q8n3x4m5r6t7u8v9', -- "Танцюй"
        1,
        NULL,
        'E',
        '01jwbq34vbgswxe90nww4n86va',
        NOW(),
        NOW());

INSERT INTO set_list_song (id, set_list_id, song_id, number, leader_id, key, pad_id, created_at, updated_at)
VALUES ('01jy1ck5w6e3c8m9n0p1q2r3s4',
        '01jy1ck1s2a9y4i5j6k7l8m9n0',
        '01jy1ci0p8w5u0e1a2b3c4d5f6', -- "Поряд"
        2,
        NULL,
        'A',
        '01jwbqhsfxynv7aqdqyszba9b7',
        NOW(),
        NOW());

INSERT INTO set_list_song (id, set_list_id, song_id, number, leader_id, key, pad_id, created_at, updated_at)
VALUES ('01jy1ck3u4c1a6k7l8m9n0p1q2',
        '01jy1ck1s2a9y4i5j6k7l8m9n0',
        '01jy0vqz3fk4f9g07dcwp6xsjf', -- "Всім серцем"
        3,
        NULL,
        'D',
        '01jwbqgqp8nt3fa3xd51pevv1p',
        NOW(),
        NOW());


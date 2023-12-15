(
    SELECT * FROM (
        SELECT
            vt2021."is_deleted",
            CASE WHEN vt2021."is_deleted" = 0 THEN '' ELSE st21."MDDS_ST" END AS "MDDS_ST",
            CASE WHEN vt2021."is_deleted" = 0 THEN '' ELSE st21."STName" END AS "STName",
            CASE WHEN vt2021."is_deleted" = 0 THEN '' ELSE st21."Status" END AS "STStatus",
            CASE WHEN vt2021."is_deleted" = 0 THEN '' ELSE dt21."MDDS_DT" END AS "MDDS_DT",
            CASE WHEN vt2021."is_deleted" = 0 THEN '' ELSE dt21."DTName" END AS "DTName",
            CASE WHEN vt2021."is_deleted" = 0 THEN '' ELSE sd21."MDDS_SD" END AS "MDDS_SD",
            CASE WHEN vt2021."is_deleted" = 0 THEN '' ELSE sd21."SDName" END AS "SDName",
            vt2021."ID",
            CASE WHEN vt2021."is_deleted" = 0 THEN '' ELSE vt2021."VTName" END AS "VTName",
            CASE WHEN vt2021."is_deleted" = 0 THEN '' ELSE vt2021."MDDS_VT" END AS "MDDS_VT",
            CASE WHEN vt2021."is_deleted" = 0 THEN '' ELSE vt2021."Level" END AS "Level",
            CASE WHEN vt2021."is_deleted" = 0 THEN '' ELSE vt2021."Status" END AS "Status",
            fr21.*
        FROM vt2021
        INNER JOIN (
            SELECT DISTINCT ON (forreaddata2021."VTIDACTIVE")
                forreaddata2021."STIDACTIVE",
                forreaddata2021."frfromaction"::TEXT,
                forreaddata2021."DTIDACTIVE",
                forreaddata2021."SDIDACTIVE",
                forreaddata2021."VTIDACTIVE",
                forreaddata2021."VTIDR",
                vt2011."STID2011",
                vt2011."STName2011",
                vt2011."STStatus2011",
                vt2011."MDDS_ST2011",
                vt2011."DTID2011",
                vt2011."DTName2011",
                vt2011."MDDS_DT2011",
                vt2011."SDID2011",
                vt2011."SDName2011",
                vt2011."MDDS_SD2011",
                vt2011."VTID" AS "VTID2011",
                vt2011."VTName" AS "VTName2011",
                vt2011."MDDS_VT" AS "MDDS_VT2011",
                vt2011."Level" AS "Level2011",
                vt2011."Status" AS "Status2011"
            FROM forreaddata2021
            LEFT JOIN (
                SELECT *
                FROM vt2011
                INNER JOIN (
                    SELECT
                        "STID" AS "STID2011",
                        "STName" AS "STName2011",
                        "Status" AS "STStatus2011",
                        "MDDS_ST" AS "MDDS_ST2011"
                    FROM st2011
                ) AS st11 ON st11."STID2011" = vt2011."STID"
                INNER JOIN (
                    SELECT
                        "DTID" AS "DTID2011",
                        "DTName" AS "DTName2011",
                        "MDDS_DT" AS "MDDS_DT2011"
                    FROM dt2011
                ) AS dt11 ON dt11."DTID2011" = vt2011."DTID"
                INNER JOIN (
                    SELECT
                        "SDID" AS "SDID2011",
                        "SDName" AS "SDName2011",
                        "MDDS_SD" AS "MDDS_SD2011"
                    FROM sd2011
                ) AS sd11 ON sd11."SDID2011" = vt2011."SDID"
            ) AS vt2011 ON vt2011."VTID" = forreaddata2021."VTIDR"
                AND forreaddata2021."VTIDACTIVE" != 0
                AND forreaddata2021."frcomefrom" = 'Village / Town'
                AND forreaddata2021."comeaction" != 'MAIN'
        ) AS fr21 ON fr21."VTIDACTIVE" = vt2021."VTID"
            
            AND (
                fr21."VTIDACTIVE" != fr21."VTIDR"
                OR fr21."frfromaction" = 'Sub-Merge'
                OR "frfromaction" = 'Deletion'
            )
        INNER JOIN (SELECT * FROM st2021) AS st21 ON st21."STID" = vt2021."STID"
        INNER JOIN (SELECT * FROM dt2021) AS dt21 ON dt21."DTID" = vt2021."DTID"
        INNER JOIN (SELECT * FROM sd2021) AS sd21 ON sd21."SDID" = vt2021."SDID"
        WHERE vt2021."STID" =   
        UNION ALL
        SELECT
            vt2021."is_deleted",
            st21."MDDS_ST"::TEXT,
            st21."STName",
            st21."STStatus",
            dt21."MDDS_DT"::TEXT,
            dt21."DTName",
            sd21."MDDS_SD"::TEXT,
            sd21."SDName",
            vt2021."ID",
            vt2021."VTName",
            vt2021."MDDS_VT",
            vt2021."Level",
            vt2021."Status",
            vt11.*
        FROM vt2021
        INNER JOIN (
            SELECT
                "STID" AS "STID",
                "STName" AS "STName",
                "Status" AS "STStatus",
                "MDDS_ST" AS "MDDS_ST",
                st2021."is_deleted"
            FROM st2021
        ) AS st21 ON st21."STID" = vt2021."STID" AND st21."is_deleted" = 1
        INNER JOIN (
            SELECT
                "DTID" AS "DTID",
                "DTName" AS "DTName",
                "MDDS_DT" AS "MDDS_DT",
                dt2021."is_deleted"
            FROM dt2021
        ) AS dt21 ON dt21."DTID" = vt2021."DTID" AND dt21."is_deleted" = 1
        INNER JOIN (
            SELECT
                "SDID" AS "SDID",
                "SDName" AS "SDName",
                "MDDS_SD" AS "MDDS_SD",
                sd2021."is_deleted"
            FROM sd2021
        ) AS sd21 ON sd21."SDID" = vt2021."SDID" AND sd21."is_deleted" = 1
        LEFT JOIN (
            SELECT
                0 AS "STIDACTIVE",
                '0' AS "frfromaction",
                0 AS "DTIDACTIVE",
                0 AS "SDIDACTIVE",
                0 AS "VTIDACTIVE",
                0 AS "VTIDR",
                vt2011."STID2011",
                vt2011."STName2011",
                vt2011."STStatus2011",
                vt2011."MDDS_ST2011",
                vt2011."DTID2011",
                vt2011."DTName2011",
                vt2011."MDDS_DT2011",
                vt2011."SDID2011",
                vt2011."SDName2011",
                vt2011."MDDS_SD2011",
                vt2011."VTID" AS "VTID2011",
                vt2011."VTName" AS "VTName2011",
                vt2011."MDDS_VT" AS "MDDS_VT2011",
                vt2011."Level" AS "Level2011",
                vt2011."Status" AS "Status2011"
            FROM (
                SELECT
                    vt2011."STID",
                    vt2011."DTID",
                    vt2011."SDID",
                    vt2011."VTID",
                    vt2011."VTName",
                    vt2011."MDDS_VT",
                    vt2011."Level",
                    vt2011."Status",
                    st11."STID2011",
                    st11."STName2011",
                    st11."STStatus2011",
                    st11."MDDS_ST2011",
                    dt11."DTID2011",
                    dt11."DTName2011",
                    dt11."MDDS_DT2011",
                    sd11."SDID2011",
                    sd11."SDName2011",
                    sd11."MDDS_SD2011"
                FROM vt2011
                INNER JOIN (
                    SELECT
                        "STID" AS "STID2011",
                        "STName" AS "STName2011",
                        "Status" AS "STStatus2011",
                        "MDDS_ST" AS "MDDS_ST2011"
                    FROM st2011
                ) AS st11 ON st11."STID2011" = vt2011."STID"
                INNER JOIN (
                    SELECT
                        "DTID" AS "DTID2011",
                        "DTName" AS "DTName2011",
                        "MDDS_DT" AS "MDDS_DT2011"
                    FROM dt2011
                ) AS dt11 ON dt11."DTID2011" = vt2011."DTID"
                INNER JOIN (
                    SELECT
                        "SDID" AS "SDID2011",
                        "SDName" AS "SDName2011",
                        "MDDS_SD" AS "MDDS_SD2011"
                    FROM sd2011
                ) AS sd11 ON sd11."SDID2011" = vt2011."SDID"
            ) AS vt2011
        ) AS vt11 ON vt11."VTID2011" = vt2021."VTID"
        WHERE vt2021."STID" =   
            AND vt2021."is_deleted" = 1
            AND vt11."VTID2011" IS NOT NULL
    ) AS TAB1
) temp
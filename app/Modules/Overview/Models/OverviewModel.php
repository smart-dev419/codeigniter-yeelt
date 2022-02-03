<?php 
namespace App\Modules\Overview\Models;
use CodeIgniter\Model;

class OverviewModel
{
	protected $db;
	protected $SellersKey;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->SellersKey = intval($_SESSION['sellerData']['SellersKey']);
    }
    
    /**
     * METRIC
     * Get Revenue and sales from SellersKey
     *
     * @param array $formdata
     * @return array
     */
    public function get_Metrics($formdata) {
        $str_category = $formdata['category'];
        $level = $formdata['level'];

        switch($level) {
              case "0":
                     $category0 = 'Null';
                     $category1 = 'Null';
                     $whereColumn = 'category0';
                     $finalfield = 'Category0';
              break;
              case "1":
                     $category0 = "'".$str_category."'";
                     $category1 = 'Null';
                     $whereColumn = 'category0';
                     $finalfield = 'Category1';
              break;
              case "2":
                     $category0 = 'Null';
                     $category1 = "'".$str_category."'";
                     $whereColumn = 'category1';
                     $finalfield = 'Category2';
              break;
        }

        $query_string = "DECLARE
                            @sellerskey INT = ".$this->SellersKey.",
                            @start_dt DATE = '".$formdata['start']."',
                            @end_dt DATE = '".$formdata['end']."',
                            @diff int,
                            @previousStart DATE,
                            @previousEnd DATE,
                            @category0 VARCHAR(100) = ".$category0.",
                            @category1 VARCHAR(100) = ".$category1."

                        SELECT @diff = DATEDIFF(day, @start_dt, @end_dt) + 1
                        SELECT @previousStart = DATEADD(DAY, DATEDIFF(DAY, 0, @start_dt), -@diff)
                        SELECT @previousEnd = DATEADD(DAY, DATEDIFF(DAY, 0, @end_dt), -@diff)
                            
                        SELECT Isnull(Final.".$finalfield.", 'Total')                           AS Category,
                        Sum(Final.tempcurrentproductvisits)                        AS
                        CurrentProductvisits,
                        Sum(Final.temppreviousproductvisits)                       AS
                        PreviousProductvisits,
                        Cast(Isnull(( ( Cast(Sum(Final.tempcurrentproductvisits) AS
                                             DECIMAL (10, 5)) -
                                                      Cast(
                                                      Sum(Final.temppreviousproductvisits)AS
                                                      DECIMAL (10, 5))
                                           ) /
                 NULLIF(Cast(Sum(Final.temppreviousproductvisits) AS
                             DECIMAL (10, 5)), 0) * 100 ), 0) AS
                 DECIMAL (10, 1))                                      AS visitChange,
                 Sum(Final.tempcurrentorders)                               AS CurrentOrders,
                 Sum(Final.temppreviousorders)                              AS PreviousOrders,
                 Cast(Isnull(( ( Cast(Sum(Final.tempcurrentorders) AS DECIMAL (10, 5)) - Cast(
                   Sum(Final.temppreviousorders)AS
                   DECIMAL (10, 5)) ) / NULLIF(Cast(
                                        Sum(Final.temppreviousorders)
                                        AS DECIMAL (10, 5)), 0) * 100
                 ), 0
                 ) AS DECIMAL (10, 1))                                 AS orderChange,
                 CAST(SUM(Final.TempCurrentRevenue) * 100 / 121 as DECIMAL (10,2)) as CurrentRevenue,
                 CAST(SUM(Final.TempPreviousRevenue) * 100 / 121 as DECIMAL (10,2)) as PreviousRevenue,
                 CAST(ISNULL(((CAST(SUM(Final.TempCurrentRevenue) * 100 / 121 as DECIMAL (10,2)) - CAST(SUM(Final.TempPreviousRevenue) * 100 / 121 as DECIMAL (10,2)) ) / NULLIF(CAST(SUM(Final.TempPreviousRevenue) * 100 / 121 as DECIMAL (10,2)),0) * 100),0) as Decimal (10,1)) as revenueChange,
                 Isnull(Sum(Final.tempcurrentrank) /
                 NULLIF(Sum(Final.tempcurrentuniquerankings), 0), 0) AS CurrentAvgRanking,
                 Isnull(Sum(Final.temppreviousrank) / NULLIF(
                 Sum(Final.temppreviousuniquerankings), 0), 0)       AS PreviousAvgRanking,
                 Cast(Cast(Isnull(Sum(Final.temppreviousrank) / NULLIF(
                 Sum(Final.temppreviousuniquerankings), 0), 0) AS
                 DECIMAL (
                 10, 5)) - Cast(Isnull(Sum(Final.tempcurrentrank) /
                 NULLIF(Sum(Final.tempcurrentuniquerankings), 0), 0) AS
                 DECIMAL (10, 5)) AS DECIMAL (10, 0))                       AS RankingChange
                 FROM  (SELECT Isnull(TempCurrent.cat0, 'Total')
                               AS
                                     Category0
                                      ,
                               Isnull(TempCurrent.cat1, 'Total')
                                      AS Category1,
                               Isnull(TempCurrent.cat2, 'Total')
                               AS
                                      Category2,
                               Sum(TempCurrent.productvisits)
                               AS
                                      TempCurrentProductVisits,
                               0
                               AS
                                      TempPreviousProductVisits,
                               Sum(TempCurrent.uniqueorders)
                               AS
                                      TempCurrentOrders,
                               0
                               AS
                                      TempPreviousOrders,
                               Sum(TempCurrent.revenue)
                               AS
                                      TempCurrentRevenue,
                               0
                               AS
                                      TempPreviousRevenue,
                               Sum(TempCurrent.revenue) /
                               NULLIF(Sum(TempCurrent.uniqueorders), 0) AS
                               TempCurrentavgordervalue,
                               0
                               AS
                                      Tempreviousavgordervalue,
                               Sum(TempCurrent.avgrank)
                               AS
                                      TempCurrentRank,
                               0
                               AS
                                      TempPreviousRank,
                               Sum(TempCurrent.uniquerankings)
                               AS
                                      TempCurrentUniqueRankings,
                               0
                               AS
                                      TempPreviousUniqueRankings
                        FROM  (SELECT Isnull(NULLIF(visits.cat0, ''), 'No Category Found') AS
                                      cat0,
                                      Isnull(NULLIF(visits.cat1, ''), 'No Category Found') AS
                                      cat1,
                                      Isnull(NULLIF(visits.cat2, ''), 'No Category Found') AS
                                      cat2,
                                      Sum(visits.totalvisits)                              AS
                                      productvisits,
                                      0                                                    AS
                                      Uniqueorders,
                                      0                                                    AS
                                      Revenue,
                                      0                                                    AS
                                      avgRank,
                                      0                                                    AS
                                      UniqueRankings
                               FROM  (SELECT visits.total                     AS totalvisits,
                                             opendatalatest.parentcategories0 AS cat0,
                                             opendatalatest.parentcategories1 AS cat1,
                                             opendatalatest.parentcategories2 AS cat2,
                                             Dates.thedate                    AS datum,
                                             products.ean
                                      FROM   [dbo].datetable AS Dates
                                             LEFT JOIN [dbo].productsvisits AS visits
                                                    ON Dates.thedate = visits.[date]
                                                       AND visits.sellerskey = @sellerskey
                                             LEFT JOIN [dbo].[products] AS products
                                                    ON visits.offerid = products.offerid
                                                    LEFT JOIN (SELECT Max(opendata.opendatamutationkey)
                                                                AS
                                                                max_mutationKey,
                                                                opendata.ean
                                                                AS
                                                                EAN
                                                         FROM   [dbo].productsopendatamutations
                                                                AS
                                                                opendata
                                                         GROUP  BY ean) visitsMax
                                                     ON visitsMax.ean = products.ean
                                                     LEFT JOIN [dbo].productsopendatamutations
                                                        opendatalatest
                                                     ON opendatalatest.opendatamutationkey =
                                                        visitsMax.max_mutationkey
                                      WHERE  Dates.thedate BETWEEN @start_dt AND @end_dt) visits
                               GROUP  BY cat0,
                                         cat1,
                                         cat2
                               UNION
                               SELECT Isnull(NULLIF(SalesandOrders.cat0, ''), 'No Category Found'
                                      ) AS
                                      cat0,
                                      Isnull(NULLIF(SalesandOrders.cat1, ''), 'No Category Found'
                                      ) AS
                                      cat1,
                                      Isnull(NULLIF(SalesandOrders.cat2, ''), 'No Category Found'
                                      ) AS
                                      cat2,
                                      0
                                      AS
                                      productvisits,
                                      Count(DISTINCT orderid)
                                      AS
                                      Uniqueorders,
                                      Sum(SalesandOrders.totalrevenue)
                                      AS
                                      Revenue,
                                      0
                                      AS
                                      avgRank,
                                      0
                                      AS
                                      UniqueRankings
                               FROM  (SELECT opendatalatest.parentcategories0            AS cat0,
                                             opendatalatest.parentcategories1            AS cat1,
                                             opendatalatest.parentcategories2            AS cat2,
                                             Isnull(Items.unitprice * Items.quantity, 0) AS
                                             totalRevenue
                                             ,
                                             Items.[orderid]
                                             AS Orderid
                                      FROM   [dbo].datetable AS Dates
                                             LEFT JOIN [dbo].[sellerorders] AS Orders
                                                    ON Dates.thedate = Orders.datetimeplaced
                                                       AND Orders.sellerskey = @sellerskey
                                             LEFT JOIN [dbo].[sellerordersitems] AS Items
                                                    ON Orders.[orderid] = Items.[orderid]
                                                       AND Orders.sellerskey = @sellerskey
                                            LEFT JOIN (SELECT Max(opendata.opendatamutationkey)
                                                                AS
                                                                max_mutationKey,
                                                                opendata.ean
                                                                AS
                                                                EAN
                                                         FROM   [dbo].productsopendatamutations
                                                                AS
                                                                opendata
                                                         GROUP  BY ean) visitsMax
                                                     ON visitsMax.ean = Items.ean
                                            LEFT JOIN [dbo].productsopendatamutations
                                                        opendatalatest
                                                     ON opendatalatest.opendatamutationkey =
                                                        visitsMax.max_mutationkey
                                      WHERE  Dates.thedate BETWEEN @start_dt AND @end_dt) AS
                                     SalesandOrders
                               GROUP  BY cat0,
                                         cat1,
                                         cat2
                               UNION
                               SELECT Isnull(NULLIF(Rankings.cat0, ''), 'No Category Found') AS
                                      cat0,
                                      Isnull(NULLIF(Rankings.cat1, ''), 'No Category Found') AS
                                      cat1,
                                      Isnull(NULLIF(Rankings.cat2, ''), 'No Category Found') AS
                                      cat2,
                                      0                                                      AS
                                      productvisits,
                                      0                                                      AS
                                      Uniqueorders,
                                      0                                                      AS
                                      Revenue
                                      ,
                                      Sum(Rankings.ranking)
                                      AS avgRank,
                                      Count(Rankings.rankkey)                                AS
                                      UniqueRankings
                               FROM  (SELECT opendatalatest.parentcategories0 AS cat0,
                                             opendatalatest.parentcategories1 AS cat1,
                                             opendatalatest.parentcategories2 AS cat2,
                                             Rankingsresul.ranking            AS Ranking,
                                             Rankingsresul.rankingsresultskey AS rankKey
                                      FROM   [dbo].datetable AS Dates
                                             LEFT JOIN [dbo].[rankingsresults] AS Rankingsresul
                                                    ON Dates.thedate = CONVERT(VARCHAR,
                                                                       Rankingsresul.[datetime],
                                                                       23)
                                                       AND Rankingsresul.sellerskey = @sellerskey
                                                       LEFT JOIN (SELECT Max(opendata.opendatamutationkey)
                                                                AS
                                                                max_mutationKey,
                                                                opendata.ean
                                                                AS
                                                                EAN
                                                         FROM   [dbo].productsopendatamutations
                                                                AS
                                                                opendata
                                                         GROUP  BY ean) visitsMax
                                                     ON visitsMax.ean = Rankingsresul.ean
                                                     LEFT JOIN [dbo].productsopendatamutations
                                                        opendatalatest
                                                     ON opendatalatest.opendatamutationkey =
                                                        visitsMax.max_mutationkey
                                      WHERE  Dates.thedate BETWEEN @start_dt AND @end_dt) AS
                                     Rankings
                               GROUP  BY cat0,
                                         cat1,
                                         cat2) TempCurrent
                        GROUP  BY cat0,
                                  cat1,
                                  cat2
                        UNION
                        SELECT Isnull(TempPrevious.cat0, 'Total')
                               AS
                               Category0,
                               Isnull(TempPrevious.cat1, 'Total')
                               AS
                               Category1,
                               Isnull(TempPrevious.cat2, 'Total')
                               AS
                               Category2,
                               0
                               AS
                               TempCurrentProductVisits,
                               Sum(TempPrevious.productvisits)
                               AS
                               TempPreviousProductVisits,
                               0
                               AS
                               TempCurrentOrders,
                               Sum(TempPrevious.uniqueorders)
                               AS
                               TempPreviousOrders,
                               0
                               AS
                               TempCurrentRevenue,
                               Sum(TempPrevious.revenue)
                               AS
                               TempPreviousRevenue,
                               0
                               AS
                               TempCurrentavgordervalue,
                               Sum(TempPrevious.revenue) /
                               NULLIF(Sum(TempPrevious.uniqueorders), 0) AS
                               TempPreviousavgordervalue,
                               0
                               AS
                               TempCurrentRank,
                               Sum(TempPrevious.avgrank)
                               AS
                               TempPreviousRank,
                               0
                               AS
                               TempCurrentUniqueRankings,
                               Sum(TempPrevious.uniquerankings)
                               AS
                               TempPreviousUniqueRankings
                        FROM  (SELECT Isnull(NULLIF(visits.cat0, ''), 'No Category Found') AS
                                      cat0,
                                      Isnull(NULLIF(visits.cat1, ''), 'No Category Found') AS
                                      cat1,
                                      Isnull(NULLIF(visits.cat2, ''), 'No Category Found') AS
                                      cat2,
                                      Sum(visits.totalvisits)                              AS
                                      productvisits,
                                      0                                                    AS
                                      Uniqueorders,
                                      0                                                    AS
                                      Revenue,
                                      0                                                    AS
                                      avgRank,
                                      0                                                    AS
                                      UniqueRankings
                               FROM  (SELECT visits.total                     AS totalvisits,
                                             opendatalatest.parentcategories0 AS cat0,
                                             opendatalatest.parentcategories1 AS cat1,
                                             opendatalatest.parentcategories2 AS cat2,
                                             Dates.thedate                    AS datum,
                                             products.ean
                                      FROM   [dbo].datetable AS Dates
                                             LEFT JOIN [dbo].productsvisits AS visits
                                                    ON Dates.thedate = visits.[date]
                                                       AND visits.sellerskey = @sellerskey
                                             LEFT JOIN [dbo].[products] AS products
                                                    ON visits.offerid = products.offerid
                                                    LEFT JOIN (SELECT Max(opendata.opendatamutationkey)
                                                                AS
                                                                max_mutationKey,
                                                                opendata.ean
                                                                AS
                                                                EAN
                                                         FROM   [dbo].productsopendatamutations
                                                                AS
                                                                opendata
                                                         GROUP  BY ean) visitsMax
                                                     ON visitsMax.ean = products.ean
                                                     LEFT JOIN [dbo].productsopendatamutations
                                                        opendatalatest
                                                     ON opendatalatest.opendatamutationkey =
                                                        visitsMax.max_mutationkey
                                      WHERE  Dates.thedate BETWEEN
                                             @previousStart AND @previousEnd)
                                     visits
                               GROUP  BY cat0,
                                         cat1,
                                         cat2
                               UNION
                               SELECT Isnull(NULLIF(SalesandOrders.cat0, ''), 'No Category Found'
                                      ) AS
                                      cat0,
                                      Isnull(NULLIF(SalesandOrders.cat1, ''), 'No Category Found'
                                      ) AS
                                      cat1,
                                      Isnull(NULLIF(SalesandOrders.cat2, ''), 'No Category Found'
                                      ) AS
                                      cat2,
                                      0
                                      AS
                                      productvisits,
                                      Count(DISTINCT orderid)
                                      AS
                                      Uniqueorders,
                                      Sum(SalesandOrders.totalrevenue)
                                      AS
                                      Revenue,
                                      0
                                      AS
                                      avgRank,
                                      0
                                      AS
                                      UniqueRankings
                               FROM  (SELECT opendatalatest.parentcategories0            AS cat0,
                                             opendatalatest.parentcategories1            AS cat1,
                                             opendatalatest.parentcategories2            AS cat2,
                                             Isnull(Items.unitprice * Items.quantity, 0) AS
                                             totalRevenue
                                             ,
                                             Items.[orderid]
                                             AS Orderid
                                      FROM   [dbo].datetable AS Dates
                                             LEFT JOIN [dbo].[sellerorders] AS Orders
                                                    ON Dates.thedate = Orders.datetimeplaced
                                                       AND Orders.sellerskey = @sellerskey
                                             LEFT JOIN [dbo].[sellerordersitems] AS Items
                                                    ON Orders.[orderid] = Items.[orderid]
                                                       AND Orders.sellerskey = @sellerskey
                                                       LEFT JOIN (SELECT Max(opendata.opendatamutationkey)
                                                                AS
                                                                max_mutationKey,
                                                                opendata.ean
                                                                AS
                                                                EAN
                                                         FROM   [dbo].productsopendatamutations
                                                                AS
                                                                opendata
                                                         GROUP  BY ean) visitsMax
                                                     ON visitsMax.ean = Items.ean
                                                     LEFT JOIN [dbo].productsopendatamutations
                                                        opendatalatest
                                                     ON opendatalatest.opendatamutationkey =
                                                        visitsMax.max_mutationkey
                                      WHERE  Dates.thedate BETWEEN
                                             @previousStart AND @previousEnd) AS
                                     SalesandOrders
                               GROUP  BY cat0,
                                         cat1,
                                         cat2
                               UNION
                               SELECT Isnull(NULLIF(Rankings.cat0, ''), 'No Category Found') AS
                                      cat0,
                                      Isnull(NULLIF(Rankings.cat1, ''), 'No Category Found') AS
                                      cat1,
                                      Isnull(NULLIF(Rankings.cat2, ''), 'No Category Found') AS
                                      cat2,
                                      0                                                      AS
                                      productvisits,
                                      0                                                      AS
                                      Uniqueorders,
                                      0                                                      AS
                                      Revenue
                                      ,
                                      Sum(Rankings.ranking)
                                      AS avgRank,
                                      Count(Rankings.rankkey)                                AS
                                      CurrentUniqueRankings
                               FROM  (SELECT opendatalatest.parentcategories0 AS cat0,
                                             opendatalatest.parentcategories1 AS cat1,
                                             opendatalatest.parentcategories2 AS cat2,
                                             Rankingsresul.ranking            AS Ranking,
                                             Rankingsresul.rankingsresultskey AS rankKey
                                      FROM   [dbo].datetable AS Dates
                                             LEFT JOIN [dbo].[rankingsresults] AS Rankingsresul
                                                    ON Dates.thedate = CONVERT(VARCHAR,
                                                                       Rankingsresul.[datetime],
                                                                       23)
                                                       AND Rankingsresul.sellerskey = @sellerskey
                                                       LEFT JOIN (SELECT Max(opendata.opendatamutationkey)
                                                                AS
                                                                max_mutationKey,
                                                                opendata.ean
                                                                AS
                                                                EAN
                                                         FROM   [dbo].productsopendatamutations
                                                                AS
                                                                opendata
                                                         GROUP  BY ean) visitsMax
                                                     ON visitsMax.ean = Rankingsresul.ean
                                                     LEFT JOIN [dbo].productsopendatamutations
                                                        opendatalatest
                                                     ON opendatalatest.opendatamutationkey =
                                                        visitsMax.max_mutationkey
                                      WHERE  Dates.thedate BETWEEN
                                             @previousStart AND @previousEnd) AS
                                     Rankings
                               GROUP  BY cat0,
                                         cat1,
                                         cat2) TempPrevious
                        GROUP  BY cat0,
                                  cat1,
                                  cat2) Final
                 WHERE  ".$whereColumn." = @".$whereColumn." OR @".$whereColumn." IS NULL
                 GROUP  BY rollup ( ".strtolower($finalfield)." )
                 ORDER BY CurrentProductvisits DESC";

        $query = $this->db->query($query_string); 
        $data = $query->getResultArray();

        $return = [];
        $keyunset = '';
        $totals = '';
        if(is_array($data) && isset($data[0])) {
              foreach($data as $key => $row) :
                     if($row['Category'] == "Total") {
                            $totals = $row;
                     } else {
                            $return[] = $row;
                     }
              endforeach;
        }

        if(is_array($totals)) 
              $return[] = $totals;

        return $return;
    }

    /**
     * Table Products
     * Get all the information from products
     *
     * @param array $formdata
     * @return array
     */
    public function get_Metrics_Products($formdata) {
        $str_category = $formdata['category'];
        $level = $formdata['level'];

        switch($level) {
              case "0":
                     $category0 = 'Null';
                     $category1 = 'Null';
                     $whereColumn = 'category0';
                     $parentCategories = 'Categories0';
              break;
              case "1":
                     $category0 = "'".$str_category."'";
                     $category1 = 'Null';
                     $whereColumn = 'category0';
                     $parentCategories = 'Categories0';
              break;
              case "2":
                     $category0 = 'Null';
                     $category1 = "'".$str_category."'";
                     $whereColumn = 'category1';
                     $parentCategories = 'Categories1';
              break;
        }

        $query_string = "DECLARE
                            @sellerskey INT = ".$this->SellersKey.",
                            @start_dt DATE = '".$formdata['start']."',
                            @end_dt DATE = '".$formdata['end']."',
                            @diff int,
                            @previousStart DATE,
                            @previousEnd DATE,
                            @category0 VARCHAR(100) = ".$category0.",
                            @category1 VARCHAR(100) = ".$category1."
                     
                            SELECT @diff = DATEDIFF(day, @start_dt, @end_dt) + 1
                            SELECT @previousStart = DATEADD(DAY, DATEDIFF(DAY, 0, @start_dt), -@diff)
                            SELECT @previousEnd = DATEADD(DAY, DATEDIFF(DAY, 0, @end_dt), -@diff)
                            SELECT
                            ISNULL(Final.ProductFinal, 'Total') as Product,
                            SUM(Final.TempCurrentProductVisits) as CurrentProductvisits,
                            SUM(Final.TempPreviousProductVisits) as PreviousProductvisits,
                            CAST(ISNULL(((CAST(SUM(Final.TempCurrentProductVisits) as DECIMAL (10,5)) - CAST(SUM(Final.TempPreviousProductVisits)as DECIMAL (10,5)) ) / NULLIF(CAST(SUM(Final.TempPreviousProductVisits) as DECIMAL (10,5)),0) * 100),0) as Decimal (10,1)) as visitChange,
                            SUM(Final.TempCurrentOrders) as CurrentOrders,
                            SUM(Final.TempPreviousOrders) as PreviousOrders,
                            CAST(ISNULL(((CAST(SUM(Final.TempCurrentOrders) as DECIMAL (10,5)) - CAST(SUM(Final.TempPreviousOrders)as DECIMAL (10,5)) ) / NULLIF(CAST(SUM(Final.TempPreviousOrders) as DECIMAL (10,5)),0) * 100),0) as Decimal (10,1)) as orderChange,
                            CAST(SUM(Final.TempCurrentRevenue) * 100 / 121 as DECIMAL (10,2)) as CurrentRevenue,
                            CAST(SUM(Final.TempPreviousRevenue) * 100 / 121 as DECIMAL (10,2)) as PreviousRevenue,
                            CAST(ISNULL(((CAST(SUM(Final.TempCurrentRevenue) * 100 / 121 as DECIMAL (10,5)) - CAST(SUM(Final.TempPreviousRevenue) * 100 / 121 as DECIMAL (10,5)) ) / NULLIF(CAST(SUM(Final.TempPreviousRevenue) * 100 / 121 as DECIMAL (10,5)),0) * 100),0) as Decimal (10,1)) as revenueChange,
                            ISNULL(SUM(Final.TempCurrentRank) / NULLIF(SUM(Final.TempCurrentUniqueRankings),0),0) as CurrentAvgRanking,
                            ISNULL(SUM(Final.TempPreviousRank) / NULLIF(SUM(Final.TempPreviousUniqueRankings),0),0) as PreviousAvgRanking,
                            CAST(CAST(ISNULL(SUM(Final.TempPreviousRank) / NULLIF(SUM(Final.TempPreviousUniqueRankings),0),0) as DECIMAL (10,5)) - CAST(ISNULL(SUM(Final.TempCurrentRank) / NULLIF(SUM(Final.TempCurrentUniqueRankings),0),0) as DECIMAL (10,5)) as DECIMAL (10,0)) as RankingChange
                            FROM(
                            SELECT
                            ISNULL(TempCurrent.Product, 'Total') as ProductFinal,
                            SUM(TempCurrent.productvisits) as TempCurrentProductVisits,
                            0 as TempPreviousProductVisits,
                            SUM(TempCurrent.Uniqueorders) as TempCurrentOrders,
                            0 as TempPreviousOrders,
                            SUM(TempCurrent.Revenue) as TempCurrentRevenue,
                            0 as TempPreviousRevenue,
                            SUM(TempCurrent.Revenue) / NULLIF(SUM(TempCurrent.Uniqueorders),0) as TempCurrentavgordervalue,
                            0 as Tempreviousavgordervalue,
                            SUM(TempCurrent.avgRank) as TempCurrentRank,
                            0 as TempPreviousRank,
                            SUM(TempCurrent.UniqueRankings) as TempCurrentUniqueRankings,
                            0 as TempPreviousUniqueRankings
                            FROM(
                            SELECT
                            ISNULL(NULLIF(visits.Productitle, ''), 'No Title Found') as Product,
                            SUM(visits.totalvisits) as productvisits,
                            0 as Uniqueorders,
                            0 as Revenue,
                            0 as avgRank,
                            0 as UniqueRankings  
                            FROM(
                            SELECT visits.Total as totalvisits,
                            opendatalatest.parentCategories0 as cat0,
                            opendatalatest.parentCategories1 as cat1,
                            opendatalatest.parentCategories2 as cat2,
                            Dates.TheDate as datum,
                            products.Ean,
                            opendatalatest.Title as Productitle
                            FROM [dbo].DateTable as Dates
                            LEFT JOIN [dbo].ProductsVisits as visits
                            ON Dates.TheDate = visits.[Date] and visits.SellersKey = @sellerskey
                            LEFT JOIN [dbo].[Products] as products
                            ON visits.OfferId = products.OfferId
                            INNER JOIN  (
                                   SELECT    MAX(opendata.OpenDataMutationKey) as max_mutationKey, opendata.Ean as EAN
                                   FROM      [dbo].ProductsOpenDataMutations as opendata
                                   GROUP BY  EAN
                                   ) visitsMax ON visitsMax.EAN = products.Ean
                            INNER JOIN [dbo].ProductsOpenDataMutations opendatalatest
                            ON opendatalatest.OpenDataMutationKey = visitsMax.max_mutationKey
                            WHERE Dates.TheDate BETWEEN @start_dt AND @end_dt AND opendatalatest.parent".$parentCategories." = @".$whereColumn." OR @".$whereColumn." is NULL AND Dates.TheDate BETWEEN @start_dt AND @end_dt
                            ) visits
                            GROUP BY Productitle
                            UNION
                            SELECT
                            ISNULL(NULLIF(SalesandOrders.Productitle, ''), 'No Title Found') as Product,
                            0 as productvisits,
                            COUNT(DISTINCT Orderid) as Uniqueorders,
                            SUM(SalesandOrders.totalRevenue) as Revenue,
                            0 as avgRank,
                            0 as UniqueRankings
                            FROM(
                            SELECT opendatalatest.parentCategories0 as cat0,
                            opendatalatest.parentCategories1 as cat1,
                            opendatalatest.parentCategories2 as cat2,
                            opendatalatest.Title as Productitle,
                            ISNULL(Items.UnitPrice *Items.Quantity, 0) as totalRevenue,
                            Items.[OrderID] as Orderid
                            FROM [dbo].DateTable as Dates
                            LEFT JOIN [dbo].[SellerOrders] as Orders
                            ON Dates.TheDate = Orders.DateTimePlaced AND Orders.SellersKey = @sellerskey
                            LEFT JOIN [dbo].[SellerOrdersItems] as Items
                            ON Orders.[OrderID] = Items.[OrderID] AND Orders.SellersKey = @sellerskey
                            INNER JOIN  (
                            SELECT    MAX(opendata.OpenDataMutationKey) as max_mutationKey, opendata.Ean as EAN
                            FROM      [dbo].ProductsOpenDataMutations as opendata
                            GROUP BY  EAN
                            ) visitsMax ON visitsMax.EAN = Items.Ean
                            INNER JOIN [dbo].ProductsOpenDataMutations opendatalatest
                            ON opendatalatest.OpenDataMutationKey = visitsMax.max_mutationKey
                            WHERE Dates.TheDate BETWEEN @start_dt AND @end_dt AND opendatalatest.parent".$parentCategories." = @".$whereColumn." OR @".$whereColumn." is NULL AND Dates.TheDate BETWEEN @start_dt AND @end_dt
                            ) AS SalesandOrders
                            GROUP BY Productitle
                            UNION
                            SELECT
                            ISNULL(NULLIF(Rankings.Productitle, ''), 'No Title Found') as Product,
                            0 as productvisits,
                            0 as Uniqueorders,
                            0 as Revenue,
                            SUM(Rankings.Ranking) as avgRank,
                            COUNT(Rankings.rankKey) as UniqueRankings
                            FROM(
                            SELECT opendatalatest.parentCategories0 as cat0,
                            opendatalatest.parentCategories1 as cat1, opendatalatest.parentCategories2 as cat2,
                            Rankingsresul.Ranking as Ranking, Rankingsresul.RankingsResultsKey as rankKey, opendatalatest.Title as Productitle
                            FROM [dbo].DateTable as Dates
                            LEFT JOIN [dbo].[RankingsResults] as Rankingsresul
                            ON Dates.TheDate = convert(varchar, Rankingsresul.[DateTime], 23) AND Rankingsresul.SellersKey = @sellerskey
                            INNER JOIN  (
                            SELECT    MAX(opendata.OpenDataMutationKey) as max_mutationKey, opendata.Ean as EAN
                            FROM      [dbo].ProductsOpenDataMutations as opendata
                            GROUP BY  EAN
                            ) visitsMax ON visitsMax.EAN = Rankingsresul.Ean
                            INNER JOIN [dbo].ProductsOpenDataMutations opendatalatest
                            ON opendatalatest.OpenDataMutationKey = visitsMax.max_mutationKey
                            WHERE Dates.TheDate BETWEEN @start_dt AND @end_dt AND opendatalatest.parent".$parentCategories." = @".$whereColumn." OR @".$whereColumn." is NULL AND Dates.TheDate BETWEEN @start_dt AND @end_dt
                            ) AS Rankings
                            GROUP BY Productitle
                            ) TempCurrent
                            GROUP BY Product
                            UNION
                            SELECT
                            ISNULL(TempPrevious.Product, 'Total') as Product,
                            0 as TempCurrentProductVisits,
                            SUM(TempPrevious.productvisits) as TempPreviousProductVisits,
                            0 as TempCurrentOrders,
                            SUM(TempPrevious.Uniqueorders) as TempPreviousOrders,
                            0 as TempCurrentRevenue,
                            SUM(TempPrevious.Revenue) as TempPreviousRevenue,
                            0 as TempCurrentavgordervalue,
                            SUM(TempPrevious.Revenue) / NULLIF(SUM(TempPrevious.Uniqueorders),0) as TempPreviousavgordervalue,
                            0 as TempCurrentRank,
                            SUM(TempPrevious.avgRank) as TempPreviousRank,
                            0 as TempCurrentUniqueRankings,
                            SUM(TempPrevious.UniqueRankings) as TempPreviousUniqueRankings
                            FROM(
                            SELECT
                            ISNULL(NULLIF(visits.Productitle, ''), 'No Title Found') as Product,
                            SUM(visits.totalvisits) as productvisits,
                            0 as Uniqueorders,
                            0 as Revenue,
                            0 as avgRank,
                            0 as UniqueRankings  
                            FROM(
                            SELECT visits.Total as totalvisits,
                            opendatalatest.parentCategories0 as cat0,
                            opendatalatest.parentCategories1 as cat1,
                            opendatalatest.parentCategories2 as cat2,
                            Dates.TheDate as datum,
                            products.Ean, opendatalatest.Title as Productitle
                            FROM [dbo].DateTable as Dates
                            LEFT JOIN [dbo].ProductsVisits as visits
                            ON Dates.TheDate = visits.[Date] and visits.SellersKey = @sellerskey
                            LEFT JOIN [dbo].[Products] as products
                            ON visits.OfferId = products.OfferId
                            INNER JOIN  (
                                   SELECT    MAX(opendata.OpenDataMutationKey) as max_mutationKey, opendata.Ean as EAN
                                   FROM      [dbo].ProductsOpenDataMutations as opendata
                                   GROUP BY  EAN
                                   ) visitsMax ON visitsMax.EAN = products.Ean
                            INNER JOIN [dbo].ProductsOpenDataMutations opendatalatest
                            ON opendatalatest.OpenDataMutationKey = visitsMax.max_mutationKey
                            WHERE Dates.TheDate BETWEEN @previousStart AND @previousEnd AND opendatalatest.parent".$parentCategories." = @".$whereColumn." OR @".$whereColumn." is NULL AND Dates.TheDate BETWEEN @previousStart AND @previousEnd
                            ) visits
                            GROUP BY Productitle
                            UNION
                            SELECT
                            ISNULL(NULLIF(SalesandOrders.Productitle, ''), 'No Title Found') as Product,
                            0 as productvisits,
                            COUNT(DISTINCT Orderid) as Uniqueorders,
                            SUM(SalesandOrders.totalRevenue) as Revenue,
                            0 as avgRank,
                            0 as UniqueRankings
                            FROM(
                            SELECT opendatalatest.parentCategories0 as cat0,
                            opendatalatest.parentCategories1 as cat1, opendatalatest.parentCategories2 as cat2,
                            ISNULL(Items.UnitPrice *Items.Quantity, 0) as totalRevenue,
                            Items.[OrderID] as Orderid, opendatalatest.Title as Productitle
                            FROM [dbo].DateTable as Dates
                            LEFT JOIN [dbo].[SellerOrders] as Orders
                            ON Dates.TheDate = Orders.DateTimePlaced AND Orders.SellersKey = @sellerskey
                            LEFT JOIN [dbo].[SellerOrdersItems] as Items
                            ON Orders.[OrderID] = Items.[OrderID] AND Orders.SellersKey = @sellerskey
                            INNER JOIN  (
                            SELECT    MAX(opendata.OpenDataMutationKey) as max_mutationKey, opendata.Ean as EAN
                            FROM      [dbo].ProductsOpenDataMutations as opendata
                            GROUP BY  EAN
                            ) visitsMax ON visitsMax.EAN = Items.Ean
                            INNER JOIN [dbo].ProductsOpenDataMutations opendatalatest
                            ON opendatalatest.OpenDataMutationKey = visitsMax.max_mutationKey
                            WHERE Dates.TheDate BETWEEN @previousStart AND @previousEnd AND opendatalatest.parent".$parentCategories." = @".$whereColumn." OR @".$whereColumn." is NULL AND Dates.TheDate BETWEEN @previousStart AND @previousEnd
                            ) AS SalesandOrders
                            GROUP BY Productitle
                            UNION
                            SELECT
                            ISNULL(NULLIF(Rankings.Productitle, ''), 'No Title Found') as Product,
                            0 as productvisits,
                            0 as Uniqueorders,
                            0 as Revenue,
                            SUM(Rankings.Ranking) as avgRank,
                            COUNT(Rankings.rankKey) as CurrentUniqueRankings
                            FROM(
                            SELECT opendatalatest.parentCategories0 as cat0,
                            opendatalatest.parentCategories1 as cat1, opendatalatest.parentCategories2 as cat2,
                            Rankingsresul.Ranking as Ranking, Rankingsresul.RankingsResultsKey as rankKey, opendatalatest.Title as Productitle
                            FROM [dbo].DateTable as Dates
                            LEFT JOIN [dbo].[RankingsResults] as Rankingsresul
                            ON Dates.TheDate = convert(varchar, Rankingsresul.[DateTime], 23) AND Rankingsresul.SellersKey = @sellerskey
                            INNER JOIN  (
                            SELECT    MAX(opendata.OpenDataMutationKey) as max_mutationKey, opendata.Ean as EAN
                            FROM      [dbo].ProductsOpenDataMutations as opendata
                            GROUP BY  EAN
                            ) visitsMax ON visitsMax.EAN = Rankingsresul.Ean
                            INNER JOIN [dbo].ProductsOpenDataMutations opendatalatest
                            ON opendatalatest.OpenDataMutationKey = visitsMax.max_mutationKey
                            WHERE Dates.TheDate BETWEEN @previousStart AND @previousEnd AND opendatalatest.parent".$parentCategories." = @".$whereColumn." OR @".$whereColumn." is NULL AND Dates.TheDate BETWEEN @previousStart AND @previousEnd
                            ) AS Rankings
                            GROUP BY Productitle
                            ) TempPrevious
                            GROUP BY Product
                            ) Final
                            GROUP BY ROLLUP (ProductFinal)
                            ORDER BY CurrentProductvisits DESC
                        ";

        $query = $this->db->query($query_string); 
        $data = $query->getResultArray();

        $return = [];
        $keyunset = '';
        $totals = '';
        if(is_array($data) && isset($data[0])) {
              foreach($data as $key => $row) :
                     if($row['Product'] == "Total") {
                            $totals = $row;
                     } else {
                            $return[] = $row;
                     }
              endforeach;
        }

        if(is_array($totals)) 
              $return[] = $totals;

        return $return;
    }

    /**
     * CHART
     * Get Revenue and sales from SellersKey
     *
     * @param array $formdata
     * @return array
     */
    public function get_ChartRevenueSales($formdata) {
       $str_category = $formdata['category'];
       $level = $formdata['level'];

       switch($level) {
             case "0":
                    $category0 = 'Null';
                    $category1 = 'Null';
                    $whereColumn = 'category0';
                    $parentCategories = 'Categories0';
             break;
             case "1":
                    $category0 = "'".$str_category."'";
                    $category1 = 'Null';
                    $whereColumn = 'category0';
                    $parentCategories = 'Categories0';
             break;
             case "2":
                    $category0 = 'Null';
                    $category1 = "'".$str_category."'";
                    $whereColumn = 'category1';
                    $parentCategories = 'Categories1';
             break;
       }

       $query_string = "
                    DECLARE
                     @sellerskey INT = ".$this->SellersKey.",
                     @start_dt DATE = '".$formdata['start']."',
                     @end_dt DATE = '".$formdata['end']."',
                     @diff int,
                     @previousStart DATE,
                     @previousEnd DATE,
                     @category0 VARCHAR(100) = ".$category0.",
                     @category1 VARCHAR(100) = ".$category1."
                     
                     SELECT @diff = DATEDIFF(day, @start_dt, @end_dt) + 1
                     SELECT @previousStart = DATEADD(DAY, DATEDIFF(DAY, 0, @start_dt), -@diff)
                     SELECT @previousEnd = DATEADD(DAY, DATEDIFF(DAY, 0, @end_dt), -@diff)
                     
                     SELECT totaal.Datumtotal,
                     SUM(totaal.ProductVisits) as ProductVisits,
                     SUM(totaal.Orders) as Orders,
                     SUM(totaal.Revenue) as Revenue,
                     SUM(totaal.CurrentAvgRanking) as CurrentAvgRanking
                     
                     FROM(
                     
                     
                     SELECT
                     grafiek.datumtemp as Datumtotal,
                     SUM(grafiek.productvisits) as ProductVisits,
                     SUM(grafiek.Uniqueorders) as Orders,
                     CAST(SUM(grafiek.Revenue) * 100 / 121 as DECIMAL (10,2)) as Revenue,
                     ISNULL(SUM(grafiek.avgRank) / NULLIF(SUM(grafiek.UniqueRankings),0),0) as CurrentAvgRanking
                     
                     FROM(
                     SELECT
                     visits.datum as datumtemp,
                     SUM(visits.totalvisits) as productvisits,
                     0 as Uniqueorders,
                     0 as Revenue,
                     0 as avgRank,
                     0 as UniqueRankings   
                     FROM(
                            SELECT visits.Total as totalvisits,
                            opendatalatest.parentCategories0 as cat0,
                            opendatalatest.parentCategories1 as cat1,
                            opendatalatest.parentCategories2 as cat2,
                            Dates.TheDate as datum,
                            products.Ean
                            FROM [dbo].DateTable as Dates
                            LEFT JOIN [dbo].ProductsVisits as visits
                            ON Dates.TheDate = visits.[Date] and visits.SellersKey = @sellerskey
                            LEFT JOIN [dbo].[Products] as products
                            ON visits.OfferId = products.OfferId
                            LEFT JOIN  (
                            SELECT    MAX(opendata.OpenDataMutationKey) as max_mutationKey, opendata.Ean as EAN
                            FROM      [dbo].ProductsOpenDataMutations as opendata
                            GROUP BY  EAN
                            ) visitsMax ON visitsMax.EAN = products.Ean
                            LEFT JOIN [dbo].ProductsOpenDataMutations opendatalatest
                            ON opendatalatest.OpenDataMutationKey = visitsMax.max_mutationKey
                            WHERE Dates.TheDate BETWEEN @previousStart AND @end_dt AND opendatalatest.parent".$parentCategories." = @".$whereColumn." OR @".$whereColumn." is NULL AND Dates.TheDate BETWEEN @previousStart AND @end_dt
                            ) visits
                     GROUP BY visits.datum
                     
                     
                     UNION
                     
                     SELECT
                     SalesandOrders.datum as datumtemp,
                     0 as productvisits,
                     COUNT(DISTINCT Orderid) as Uniqueorders,
                     SUM(SalesandOrders.totalRevenue) as Revenue,
                     0 as avgRank,
                     0 as UniqueRankings
                     FROM(
                     SELECT
                     Dates.TheDate as datum,
                     opendatalatest.parentCategories0 as cat0,
                     opendatalatest.parentCategories1 as cat1,
                     opendatalatest.parentCategories2 as cat2,
                     ISNULL(Items.UnitPrice *Items.Quantity, 0) as totalRevenue,
                     Items.[OrderID] as Orderid
                     FROM [dbo].DateTable as Dates
                     LEFT JOIN [dbo].[SellerOrders] as Orders
                     ON Dates.TheDate = Orders.DateTimePlaced AND Orders.SellersKey = @sellerskey
                     LEFT JOIN [dbo].[SellerOrdersItems] as Items
                     ON Orders.[OrderID] = Items.[OrderID] AND Orders.SellersKey = @sellerskey
                     LEFT JOIN  (
                     SELECT    MAX(opendata.OpenDataMutationKey) as max_mutationKey, opendata.Ean as EAN
                     FROM      [dbo].ProductsOpenDataMutations as opendata
                     GROUP BY  EAN
                     ) visitsMax ON visitsMax.EAN = Items.Ean
                     LEFT JOIN [dbo].ProductsOpenDataMutations opendatalatest
                     ON opendatalatest.OpenDataMutationKey = visitsMax.max_mutationKey
                     WHERE Dates.TheDate BETWEEN @previousStart AND @end_dt AND opendatalatest.parent".$parentCategories." = @".$whereColumn." OR @".$whereColumn." is NULL AND Dates.TheDate BETWEEN @previousStart AND @end_dt
                     
                     ) AS SalesandOrders
                     GROUP BY SalesandOrders.datum
                     
                     UNION
                     
                     SELECT
                     Rankings.datum as datumtemp,
                     0 as productvisits,
                     0 as Uniqueorders,
                     0 as Revenue,
                     SUM(Rankings.Ranking) as avgRank,
                     COUNT(Rankings.rankKey) as UniqueRankings
                     FROM(
                     SELECT Dates.TheDate as datum, opendatalatest.parentCategories0 as cat0,
                     opendatalatest.parentCategories1 as cat1, opendatalatest.parentCategories2 as cat2,
                     Rankingsresul.Ranking as Ranking, Rankingsresul.RankingsResultsKey as rankKey
                     FROM [dbo].DateTable as Dates
                     LEFT JOIN [dbo].[RankingsResults] as Rankingsresul
                     ON Dates.TheDate = convert(varchar, Rankingsresul.[DateTime], 23) AND Rankingsresul.SellersKey = @sellerskey
                     LEFT JOIN  (
                     SELECT    MAX(opendata.OpenDataMutationKey) as max_mutationKey, opendata.Ean as EAN
                     FROM      [dbo].ProductsOpenDataMutations as opendata
                     GROUP BY  EAN
                     ) visitsMax ON visitsMax.EAN = Rankingsresul.Ean
                     LEFT JOIN [dbo].ProductsOpenDataMutations opendatalatest
                     ON opendatalatest.OpenDataMutationKey = visitsMax.max_mutationKey
                     WHERE Dates.TheDate BETWEEN @previousStart AND @end_dt AND opendatalatest.parent".$parentCategories." = @".$whereColumn." OR @".$whereColumn." is NULL AND Dates.TheDate BETWEEN @previousStart AND @end_dt
                     ) AS Rankings
                     GROUP BY Rankings.datum
                     ) grafiek
                     GROUP BY datumtemp
                     
                     UNION
                     
                     SELECT
                     alledatums.datum as datumtemp,
                     0 as ProductVisits,
                     0 as Orders,
                     0 as Revenue,
                     0 as CurrentAvgRanking
                     FROM(
                     SELECT Dates.TheDate as datum
                     FROM [dbo].DateTable as Dates
                     WHERE Dates.TheDate BETWEEN @previousStart AND @end_dt
                     ) alledatums
                     
                     GROUP BY datum
                     
                     ) totaal
                     
                     GROUP BY Datumtotal";

        $query = $this->db->query($query_string);
        $data = $query->getResultArray();
        
        $revenue_prev = [];
        $sales_prev = [];
        $ranking_prev = [];
        $visits_prev = [];
        $prev_period = TRUE;

        $dates = [];
        $revenue = [];
        $sales = [];
        $ranking = [];
        $visits = [];
        if(is_array($data) && count($data) > 0) {
            foreach($data as $row) :
                if($row['Datumtotal'] != $formdata['start'] && $prev_period == TRUE) {
                     $revenue_prev[] = $row['Revenue'];
                     $sales_prev[] = $row['Orders'];
                     $ranking_prev[] = $row['CurrentAvgRanking'];
                     $visits_prev[] = $row['ProductVisits'];
                } else {
                     $prev_period = FALSE;
                     $dates[] = $row['Datumtotal'];

                     $revenue[] = $row['Revenue'];
                     $sales[] = $row['Orders'];
                     $ranking[] = $row['CurrentAvgRanking'];
                     $visits[] = $row['ProductVisits'];
                }
            endforeach;
        }

        /**
         * Return data as array
         */
        return array(
            'Revenue' => array(
                'labels' => $dates,
                'datasets' => array(
                    array(
                        'type' => 'line',
                        'label' => 'Revenue',
                        'backgroundColor' => 'rgba(23, 102, 255, 0.2)',
                        'borderColor' => 'rgba(23, 102, 255, 1)',
                        'borderWidth' => 3,
                        'order' => 1,
                        'pointBorderColor' => 'rgba(0, 0, 0, 0)',
                        'pointBackgroundColor' => 'rgba(0, 0, 0, 0)',
                        'pointHoverBackgroundColor' => 'rgba(23, 102, 255, 1)',
                        'pointHoverBorderColor' => 'rgba(23, 102, 255, 1)',
                        'data' => $revenue
                    ),
                    array(
                        'type' => 'line',
                        'borderDash' => array('3','3'),
                        'pointRadius' => 0,
                        'borderColor' => 'rgba(47, 49, 51, 1)',
                        'backgroundColor' => 'rgba(0, 0, 0, 0)',
                        'fill' => false,
                        'label' => 'Previous period',
                        'borderWidth' => 1,
                        'order' => 0,
                        'data' => $revenue_prev
                    ),
                ),
            ),
            'Sales' => array(
                'labels' => $dates,
                'datasets' => array(
                    array(
                            'type' => 'line',
                            'label' => 'Sales',
                            'backgroundColor' => 'rgba(23, 102, 255, 0.2)',
                            'borderColor' => 'rgba(23, 102, 255, 1)',
                            'borderWidth' => 3,
                            'order' => 1,
                            'pointBorderColor' => 'rgba(0, 0, 0, 0)',
                            'pointBackgroundColor' => 'rgba(0, 0, 0, 0)',
                            'pointHoverBackgroundColor' => 'rgba(23, 102, 255, 1)',
                            'pointHoverBorderColor' => 'rgba(23, 102, 255, 1)',
                            'data' => $sales
                    ),
                    array(
                            'type' => 'line',
                            'borderDash' => array('3','3'),
                            'pointRadius' => 0,
                            'borderColor' => 'rgba(47, 49, 51, 1)',
                            'backgroundColor' => 'rgba(0, 0, 0, 0)',
                            'fill' => false,
                            'label' => 'Previous period',
                            'borderWidth' => 1,
                            'order' => 0,
                            'data' => $sales_prev
                    ),
                ),
            ),
            'Rankings' => array(
                'labels' => $dates,
                'datasets' => array(
                    array(
                            'type' => 'line',
                            'label' => 'Ranking',
                            'backgroundColor' => 'rgba(23, 102, 255, 0.2)',
                            'borderColor' => 'rgba(23, 102, 255, 1)',
                            'borderWidth' => 3,
                            'order' => 1,
                            'pointBorderColor' => 'rgba(0, 0, 0, 0)',
                            'pointBackgroundColor' => 'rgba(0, 0, 0, 0)',
                            'pointHoverBackgroundColor' => 'rgba(23, 102, 255, 1)',
                            'pointHoverBorderColor' => 'rgba(23, 102, 255, 1)',
                            'data' => $ranking
                    ),
                    array(
                            'type' => 'line',
                            'borderDash' => array('3','3'),
                            'pointRadius' => 0,
                            'borderColor' => 'rgba(47, 49, 51, 1)',
                            'backgroundColor' => 'rgba(0, 0, 0, 0)',
                            'fill' => false,
                            'label' => 'Previous period',
                            'borderWidth' => 1,
                            'order' => 0,
                            'data' => $ranking_prev
                    ),
                ),
            ),
            'Visits' => array(
                'labels' => $dates,
                'datasets' => array(
                    array(
                            'type' => 'line',
                            'label' => 'Visits',
                            'backgroundColor' => 'rgba(23, 102, 255, 0.2)',
                            'borderColor' => 'rgba(23, 102, 255, 1)',
                            'borderWidth' => 3,
                            'order' => 1,
                            'pointBorderColor' => 'rgba(0, 0, 0, 0)',
                            'pointBackgroundColor' => 'rgba(0, 0, 0, 0)',
                            'pointHoverBackgroundColor' => 'rgba(23, 102, 255, 1)',
                            'pointHoverBorderColor' => 'rgba(23, 102, 255, 1)',
                            'data' => $visits
                    ),
                    array(
                            'type' => 'line',
                            'borderDash' => array('3','3'),
                            'pointRadius' => 0,
                            'borderColor' => 'rgba(47, 49, 51, 1)',
                            'backgroundColor' => 'rgba(0, 0, 0, 0)',
                            'fill' => false,
                            'label' => 'Previous period',
                            'borderWidth' => 1,
                            'order' => 0,
                            'data' => $visits_prev
                    ),
                ),
            )
       );
    }
}
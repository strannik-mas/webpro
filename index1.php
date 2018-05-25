<?
header('Content-Type: text/html; charset=utf-8');
//доступы
    define ('DB_HOST', 'kakvkusn.mysql.ukraine.com.ua');
    define ('DB_NAME', 'kakvkusn_shnur');
    define ('DB_LOGIN', 'kakvkusn_shnur');
    define ('DB_PASSWORD', 'fugeer3e');

//    define ('DB_HOST', 'localhost');
//    define ('DB_NAME', 'kakvkusn_shnur');
//    define ('DB_LOGIN', 'root');
//    define ('DB_PASSWORD', '');
    
    //подключение к базе
    $link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
    $link->set_charset("utf8");
//var_dump($link);
    //для обработки данных
    function clearInt($data){
            return abs((int)$data);
    }
    function clearStr($data){
            return mysqli_real_escape_string($link, trim(strip_tags($data)));
    }
    /* Перегоняем объект в массив */
    function result2Array($data, $flag = false){
            $arr = array();
            if(!$flag){
                while($row = mysqli_fetch_assoc($data)){
                    if(!empty($arr[$row['product_id']]))
                        $arr[$row['product_id']][] = $row;
                    else $arr[$row['product_id']][] = $row;
                }
            }else {
                while($row = mysqli_fetch_assoc($data)){
                    if(!empty($arr[$row['product_id']]))
                        $arr[$row['product_id']] = $row;
                    else $arr[$row['product_id']] = $row;
                } 
            }
                
                    
                return $arr;
            	
    }
    /* Выборка всех товаров и их характеристик из каталога*/
    function selectAllItems(){
        global $link;
        try{
            /*
            $sql = "SELECT t1.product_id, t1.product, t1.full_description, t1.promo_text,
                    t2.company_id, t2.list_price, t2.amount, t3.company_description,
                    t4.category
                        FROM cscart_product_descriptions t1
                        INNER JOIN cscart_products t2
                        ON t1.product_id = t2.product_id 
                        LEFT JOIN cscart_company_descriptions t3 
                        ON t3.company_id = t2.company_id
                        INNER JOIN cscart_category_descriptions t4
                        WHERE EXISTS (SELECT t5.product_id, t5.category_id
                                        FROM cscart_products_categories t5
                                        WHERE t5.product_id = t1.product_id
                                        AND t4.category_id = t5.category_id)
                        ORDER BY t1.product_id";
             * 
             */
            $sql = "SELECT product_id, product, full_description, promo_text FROM cscart_product_descriptions";
            $result = $link->query($sql);
            if (!is_object($result)) 
                    throw new Exception($link->error);
            return result2Array($result, true);
        }catch(Exception $e){
            return false;
        }	
    }

    function selectCategory(/*$arr*/){
        global $link;
        try{
            
            $sql = "SELECT t5.product_id, t5.category_id, t4.category 
                    FROM cscart_products_categories t5
                    INNER JOIN cscart_category_descriptions t4
                    ON t4.category_id = t5.category_id
                    ORDER BY t5.product_id";
            
            $result = $link->query($sql);
            if (!is_object($result)) 
                    throw new Exception($link->error);
            return result2Array($result, $arr);
        }catch(Exception $e){
                return false;
        }	
    }
    function selectOptions(){
        global $link;
        try{
            
            $sql = "SELECT product_id, company_id, list_price, amount FROM cscart_products";
            
            $result = $link->query($sql);
            if (!is_object($result)) 
                    throw new Exception($link->error);
            return result2Array($result);
        }catch(Exception $e){
                return false;
        }	
    }
    function selectCompany(){
        global $link;
        try{
            
            $sql = "SELECT t1.product_id, t2.company_id, t2.company_description
                    FROM cscart_company_descriptions t2
                    INNER JOIN cscart_products t1
                    ON t2.company_id = t1.company_id
                    ORDER BY t1.product_id";
            
            $result = $link->query($sql);
            if (!is_object($result)) 
                    throw new Exception($link->error);
            return result2Array($result);
        }catch(Exception $e){
                return false;
        }	
    }
    
    function selectImages(){
        global $link;
        try{
            
            $sql = "SELECT t2.object_id, t1.image_path, t1.image_x, t1.image_y 
                    FROM cscart_images t1
                    INNER JOIN cscart_images_links t2
                    WHERE t2.object_type = 'product' AND t2.pair_id = t1.image_id    
                    ORDER BY t2.object_id";
            
            $result = $link->query($sql);
            if (!is_object($result)) 
                    throw new Exception($link->error);
            return result2Array($result);
        }catch(Exception $e){
                return false;
        }	
    }
    
    function returnElement($res, $arr, $str, $id){
        
        foreach ($arr as $value){
            foreach ($value as $v){
                if(!empty($res[$v[$id]][$str]))
                    $res[$v[$id]][$str] .= ", ".$v[$str];
                else $res[$v[$id]][$str] = $v[$str];
            }        
        }
        return $res;
        
    }
    ?>
<table border="1" width="100%">
    <tr>
        <th>Название</th>
        <th>Описание</th>
        <th>Промо-текст</th>
        <th>Цена</th>
        <th>Количество</th>
        <th>Компания</th>
        <th>Категория</th>        
        <th>Картинка</th>
    </tr>
<?
    
    
    $goods = selectAllItems();
    
    $opt = selectOptions();
    $company = selectCompany();
    $images = selectImages();
    $categories = selectCategory();
    //$res = array_merge_recursive($goods, $opt);
    //$result = returnElement($goods, $categories,'category','product_id');
    //$result = returnElement($goods, $opt,'list_price','product_id');
    //$result = returnElement($goods, $opt,'amount','product_id');
    //$result = returnElement($goods, $company,'company_description','product_id');
    
    foreach ($categories as $val){
        foreach ($val as $category){
            if(!empty($goods[$category['product_id']]['category']))
                $goods[$category['product_id']]['category'] .= ", ".$category["category"];
            else $goods[$category['product_id']]['category'] = $category["category"];
        }        
    }
    
    foreach ($opt as $val){
        foreach ($val as $option){
            if(!empty($goods[$option['product_id']]['list_price']))
                $goods[$option['product_id']]['list_price'] .= ", ".$option["list_price"];
            else $goods[$option['product_id']]['list_price'] = $option["list_price"];
            
            if(!empty($goods[$option['product_id']]['amount']))
                $goods[$option['product_id']]['amount'] .= ", ".$option["amount"];
            else $goods[$option['product_id']]['amount'] = $option["amount"];
        }        
    }

    foreach ($company as $val){
        foreach ($val as $comp){
            if(!empty($goods[$comp['product_id']]['company_description']))
                $goods[$comp['product_id']]['company_description'] .= ", ".$comp["company_description"];
            else $goods[$comp['product_id']]['company_description'] = $comp["company_description"];
        }        
    }
    
    foreach ($images as $val){
        foreach ($val as $image){
            if(!empty($goods[$image['object_id']]['image_path']))
                $goods[$image['object_id']]['image_path'] .= ", ".$image["image_path"];
            else $goods[$image['object_id']]['image_path'] = $image["image_path"];
        }        
    }
    
//    echo "<pre>";
//    var_dump($goods);
//    echo "</pre>";
    //var_dump(array_column($goods, $images, 'product_id'));
    
    foreach ($goods as $item){
        
        echo <<<LABEL
        <tr>
            <td>{$item['product']}</td>
            <td>{$item['full_description']}</td>
            <td>{$item['promo_text']}</td>
            <td>{$item['list_price']}</td>
            <td>{$item['amount']}</td>
            <td>{$item['company_description']}</td>
            <td>{$item['category']}</td>
            <td>{$item['image_path']}</td>
        </tr>
LABEL;

    }
?>
</table>
            

    
    
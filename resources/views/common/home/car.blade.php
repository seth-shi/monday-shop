<script>

    /**
     * 本地购物车 JS 实现
     */
    function LocalCar(){}
    // 本地存储的前缀
    LocalCar._prefix = '__MOON__';
    LocalCar._store = window.localStorage;

    // 获取并且删除这个 key
    LocalCar.pull = function (key) {

        let val = LocalCar.get(key);
        LocalCar.delete(key);

        return val;
    };

    // 获取一个元素
    LocalCar.get = function (key) {

        let val = LocalCar._store.getItem(LocalCar._key(key));
        return JSON.parse(val);
    };

    // 删除一个元素
    LocalCar.delete = function (key) {

        return LocalCar._store.removeItem(LocalCar._key(key));
    };

    // 存储元素
    LocalCar.put = function (key, name, thumb, number, price) {

        let product = {
            id: key,
            name: name,
            thumb: thumb,
            number: number,
            price: price
        };

        return LocalCar._storeProduct(key, product);
    };

    // 自增数量
    LocalCar.increment = function (key, name, thumb, number, price) {

        let product = LocalCar.get(key);


        if (! product) {

            product = {
                id: key,
                thumb: thumb,
                name: name,
                number: 0,
                price: price
            };
        }

        product.number = parseInt(product.number) + parseInt(number);

        return LocalCar._storeProduct(key, product);
    };

    // 同步数量
    LocalCar.syncNumber = function (key, number) {

        let change = 0;
        let product = LocalCar.get(key);

        if (! product) {

            return false;
        }

        change = number - product.number;
        product.number = number;

        LocalCar._storeProduct(key, product);

        return change;
    };

    // 获取所有
    LocalCar.all = function () {

        let results = [];
        for (let i in LocalCar._store) {

            if (LocalCar._isValidKey(i)) {

                results.push(LocalCar.get(i))
            }
        }

        return results;
    };

    // 删除所有购物车
    LocalCar.flush = function () {

        for (let i in LocalCar._store) {

            if (LocalCar._isValidKey(i)) {

                LocalCar.delete(i);
            }
        }
    };

    // 获取购物车数量
    LocalCar.count = function () {

        return LocalCar.all().length;
    };
    // 获取购物车商品数量
    LocalCar.number = function () {

        let all = LocalCar.all();
        let number = 0;

        for (let i in all) {

            number += parseInt(all[i].number);
        }

        return number;
    };


    /****************************************
     * 私有方法
     *****************************************/
    // 格式化存储前缀
    LocalCar._key = function (key) {

        // 防止重复拼接
        if (LocalCar._isValidKey(key)) {
            return key;
        }

        return LocalCar._prefix + key;
    };

    // 是否是存储的 key
    LocalCar._isValidKey = function (key) {

        return key.indexOf(LocalCar._prefix) !== -1;
    };

    // 存储一个对象
    LocalCar._storeProduct = function (key, product) {

        return LocalCar._store.setItem(LocalCar._key(key), JSON.stringify(product));
    };
</script>

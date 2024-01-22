define([
    'uiComponent',
    'knockout',
    'jquery'
], function (Component, ko, $) {
    'use strict';

    return Component.extend({
        initialize: function () {
            this._super();
            this.product = ko.observable({});
            this.productName = ko.observable('');
            this.productPrice = ko.observable('');
            this.productStock = ko.observable('');
            this.productImageUrl = ko.observable('');
            this.productUrl = ko.observable('');

            this.loadProductData();

            setInterval(this.checkStockUpdate.bind(this), 5000);
        },

        loadProductData: function () {
            var self = this;
            var reloadUrl = '/ammagi/stock/featuredproductajax';

            $.ajax({
                url: reloadUrl,
                dataType: 'json',
                success: function (data) {
                    if (!data.error) {
                        self.product(data);
                        self.productName(data.name);
                        self.productPrice(data.price);
                        self.productStock(data.stock);
                        self.productImageUrl(data.imageUrl);
                        self.productUrl(data.productUrl);
                        $('.featured-product').addClass('flex');
                    } else {
                        console.error("Erro ao carregar o produto em destaque");
                    }
                },
                error: function () {
                    console.error("Erro na requisição AJAX");
                }
            });
        },

        checkStockUpdate: function () {
            var self = this;
            var checkUpdateUrl = '/ammagi/stock/checkStockUpdate';

            if (!self.product()) {
                console.warn('Produto não está definido, verificando novamente na próxima iteração.');
                return;
            }

            if (self.product().productId) {
                $.ajax({
                    url: checkUpdateUrl,
                    type: 'GET',
                    data: { productId: self.product().productId }, 
                    success: function (data) {

                        if (data.productId && data.productId === self.product().productId && data.stock !== undefined) {
                            self.product().stock = data.stock;
                            self.product.valueHasMutated();
                            self.updateFrontendStock(data.stock);
                        }
                    },
                    error: function () {
                        console.error("Erro ao verificar atualização de estoque");
                    }
                });
            } else {
                console.warn('ID do produto não está disponível, verificando novamente na próxima iteração.');
            }
        },

        updateFrontendStock: function (newStock) {
            $('[data-bind="text: productStock"]').text(newStock);
        }
    });
});

**AMAGGI – Avaliação Técnica Desenvolvedor Magento**

# Módulo Ammagi_ProductSpotlight
O módulo "ProductSpotlight" para Magento 2 é uma solução desenvolvida para destacar produtos específicos em sua loja online, com um foco particular em atualizações em tempo real do estoque.

Desktop
![image](https://github.com/gustavoferri/magento2-product-spotlight-stock-realtime/assets/24641762/e725a16c-9868-4c01-abb0-cba356f7e193)



Mobile

![image](https://github.com/gustavoferri/magento2-product-spotlight-stock-realtime/assets/24641762/f0b433a4-ff5c-4307-8a3f-460fe2b36fe6)


## 🚀 Começando

Essas instruções permitirão que você obtenha uma cópia do projeto em operação na sua máquina local para fins de desenvolvimento e teste.

Consulte **[Implantação](#-implanta%C3%A7%C3%A3o)** para saber como implantar o projeto.

### 📋 Pré-requisitos

Ativar Sample Data:

```
bin/magento sampledata:deploy  
```

### 🔧 Instalação

Clonar projeto

```
git clone https://github.com/gustavoferri/magento2-product-spotlight-stock-realtime.git
```

Habilitar módulo:

```
bin/magento module:enable Ammagi_ProductSpotlight
```

Executar setup:upgrade

```
bin/magento set:up
```

## 📦 Implantação

EM: **STORES > ATTRIBUTES > ATTRIBUTE SET**  
Selecionar: Default, em **Atributos não atribuídos** arrastar o atributo **em_estoque** para coluna da esquerda.

![image](https://github.com/gustavoferri/magento2-product-spotlight-stock-realtime/assets/24641762/59b3ed46-6ec8-402a-a4e9-7828706144ee)

![image](https://github.com/gustavoferri/magento2-product-spotlight-stock-realtime/assets/24641762/4a17ef25-50a0-41d4-946a-b7f0b5e7a3ac)


## 📌 Versão

Desenvolvido na versão **2.4.6-p3**

## ✒️ Autor

[Gustavo Ferri](https://www.linkedin.com/in/gustavoferri)


---
😊
      			

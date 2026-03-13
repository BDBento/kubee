# Kubee – WordPress Theme

![WordPress](https://img.shields.io/badge/WordPress-Compatible-blue)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple)
![License](https://img.shields.io/badge/license-GPLv2-green)

Tema WordPress responsivo desenvolvido para o site **Kubee**.

O objetivo do tema é apresentar **pacotes de serviços e soluções digitais**, com foco em **marketing, geração de leads e apresentação de produtos**, utilizando boas práticas de **SEO, organização de conteúdo e integração com redes sociais**.

Site oficial:
https://www.kubee.com.br/

---

# Sobre o Projeto

O **Kubee Theme** foi criado como um tema personalizado para WordPress, estruturado para facilitar a gestão de conteúdo e a apresentação de serviços digitais.

O projeto utiliza o WordPress como **CMS**, permitindo que o conteúdo do site seja facilmente gerenciado pelo painel administrativo.

O tema foi desenvolvido com foco em:

* apresentação de serviços
* venda de pacotes
* marketing digital
* estrutura otimizada para SEO
* compartilhamento em redes sociais

---

# Principais Características

### Design Responsivo

Layout adaptável para diferentes dispositivos:

* Desktop
* Tablet
* Smartphones

Garantindo boa experiência de navegação em qualquer tela.

---

### Estrutura para Venda de Serviços

O tema possui seções pensadas para:

* apresentação de soluções
* exibição de planos
* descrição de funcionalidades
* diferenciação entre pacotes
* chamadas para ação (CTA)

---

### SEO e Boas Práticas de Conteúdo

Aplicação de boas práticas para mecanismos de busca:

* estrutura semântica HTML
* headings organizados
* URLs amigáveis
* otimização de carregamento
* compatibilidade com plugins de SEO

---

### Meta Tags para Redes Sociais

O tema inclui suporte a **Open Graph**, permitindo que páginas compartilhadas exibam corretamente:

* título
* descrição
* imagem de destaque

Compatível com compartilhamento em:

* Facebook
* Instagram (via Facebook)
* LinkedIn
* WhatsApp
* Twitter/X

---

### Custom Post Types

O tema utiliza **Custom Post Types** para organizar o conteúdo.

Exemplos utilizados no projeto:

* Planos
* Depoimentos
* Cartões
* Negócios
* Ferramentas utilizadas
* Clientes

Isso facilita o gerenciamento de conteúdo diretamente pelo WordPress.

---

# Estrutura do Projeto

Organização dos arquivos do tema:

```
kubee-theme
│
├── assets
│   ├── css
│   │   └── main.css
│   │
│   ├── js
│   │   ├── clientes-media.js
│   │   └── kubee-planos-sort.js
│   │
│   ├── img
│   │   └── imagens e logos do site
│   │
│   ├── functions-customiser
│   │   └── function-banner.php
│   │
│   └── post-type
│       ├── cartoes.php
│       ├── depoimentos.php
│       ├── ferramentas-usadas.php
│       ├── negocios.php
│       ├── nossos-clientes.php
│       └── planos.php
│
├── page-templates
│   └── pagina-verde.php
│
├── template-parts
│   ├── banner-home.php
│   ├── comunicacao-home.php
│   ├── nossos_servicos.php
│   └── planos-home.php
│
├── header.php
├── footer.php
├── front-page.php
├── index.php
├── functions.php
├── style.css
├── screenshot.png
└── README.md
```

---

# Componentes do Tema

### Template Parts

Arquivos reutilizáveis para montagem da página inicial:

* banner da home
* seção de comunicação
* seção de serviços
* seção de planos

---

### Page Templates

Templates específicos para páginas personalizadas.

Exemplo:

* `pagina-verde.php`

---

### Scripts JavaScript

Alguns scripts utilizados no tema:

* ordenação dinâmica de planos
* manipulação de elementos de interface
* melhorias na experiência do usuário

---

# Gerenciamento de Conteúdo

O tema utiliza o WordPress como sistema de gerenciamento, permitindo administrar:

* planos e pacotes
* depoimentos de clientes
* clientes atendidos
* ferramentas utilizadas
* conteúdos institucionais

Tudo diretamente pelo painel do WordPress.

---

# Instalação

Clone o repositório:

```
git clone https://github.com/BDBento/kubee.git
```

Copie a pasta do tema para:

```
/wp-content/themes/
```

Ative o tema no painel do WordPress.

---

# Autor

Bruno Bento

---

# Licença

MIT License

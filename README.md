# ✈️ Sistema de Gerenciamento de Aviões

Projeto desenvolvido para a disciplina de Desenvolvimento Web, com foco em criar um sistema completo de gerenciamento de aviões com diferentes níveis de acesso e permissões.

## 🚀 Acesso ao Projeto

**Link para acesso:** [INSERIR LINK DO PROJETO AQUI]

### 👥 Credenciais de Acesso

**Usuário Admin:**
- Login: admin@admin.com
- Senha: admin123

**Usuário Comum:**
- Login: usuario@usuario.com
- Senha: usuario123

## 👥 Dupla

- Nome do Aluno 1
- Nome do Aluno 2

## 📋 Funcionalidades

O sistema possui 3 módulos principais de CRUD (Create, Read, Update, Delete):

### 1. ✈️ CRUD de Aviões (Tema Principal)
- **Listar** todos os aviões cadastrados
- **Visualizar** detalhes de cada avião
- **Cadastrar** novos aviões
- **Editar** informações dos aviões
- **Excluir** aviões do sistema

### 2. 👤 CRUD de Clientes
- Gerenciamento completo de clientes
- Cadastro com validações
- Listagem e visualização de dados

### 3. 🔐 CRUD de Usuários
- Gerenciamento de usuários do sistema
- Controle de permissões (Admin/Comum)

## 🔒 Níveis de Acesso e Permissões

| Situação | Clientes | Aviões (Tema) | Usuários |
|----------|----------|---------------|----------|
| **Não logado** | • Listar todos<br>• Visualizar<br>❌ Não cadastrar<br>❌ Não editar<br>❌ Não apagar | • Listar todos<br>• Visualizar<br>❌ Não cadastrar<br>❌ Não editar<br>❌ Não apagar | ❌ Nenhuma ação permitida |
| **Logado (comum)** | ✅ Todas as operações | ✅ Todas as operações | ❌ Nenhuma ação permitida |
| **Logado (Admin)** | ✅ Todas as operações | ✅ Todas as operações | ✅ Todas as operações |

## 🛠️ Tecnologias Utilizadas

- PHP
- MySQL
- Bootstrap
- HTML5
- CSS3
- JavaScript

## ✨ Validações Implementadas

- ✅ Autenticação de usuário
- ✅ Controle de sessão
- ✅ Validação de permissões por tipo de usuário
- ✅ Validação de campos obrigatórios nos formulários
- ✅ Proteção contra acesso não autorizado

## 📁 Estrutura do Projeto

```
crud-bootstrap-php/
├── config.php                 # Configuração do banco de dados
├── database.sql              # Script SQL para criar o banco
├── index.php                 # Página inicial/login
├── css/
│   └── style.css            # Estilos customizados
├── js/
│   └── script.js            # Scripts do cliente
├── pages/
│   ├── avioes/
│   │   ├── listar.php       # Listar aviões
│   │   ├── visualizar.php   # Visualizar detalhes
│   │   ├── criar.php        # Criar novo avião
│   │   ├── editar.php       # Editar avião
│   │   └── deletar.php      # Deletar avião
│   ├── clientes/
│   │   ├── listar.php
│   │   ├── visualizar.php
│   │   ├── criar.php
│   │   ├── editar.php
│   │   └── deletar.php
│   └── usuarios/
│       ├── listar.php
│       ├── criar.php
│       ├── editar.php
│       └── deletar.php
├── includes/
│   ├── header.php           # Cabeçalho comum
│   ├── footer.php           # Rodapé comum
│   ├── navbar.php           # Barra de navegação
│   └── session.php          # Validação de sessão
└── README_PT.md             # Este arquivo
```

## 🔧 Instalação

1. Clone o repositório:
    ```bash
    git clone https://github.com/ga067357/crud-bootstrap-php.git
    ```

2. Navegue até o diretório do projeto:
    ```bash
    cd crud-bootstrap-php
    ```

3. Importe o arquivo `database.sql` no seu banco de dados MySQL:
    ```bash
    mysql -u seu_usuario -p seu_banco < database.sql
    ```

4. Configure a conexão com o banco de dados no arquivo `config.php`:
    ```php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'seu_usuario');
    define('DB_PASS', 'sua_senha');
    define('DB_NAME', 'seu_banco');
    ```

5. Execute a aplicação em um servidor PHP:
    ```bash
    php -S localhost:8000
    ```

## 💻 Como Usar

- Acesse a aplicação no navegador em `http://localhost:8000`
- Na página inicial, faça login com uma das credenciais fornecidas
- Navegue pelos módulos usando o menu lateral
- Execute as operações de CRUD conforme suas permissões

## 📝 Fluxo de Autenticação

1. Usuário acessa a página de login
2. Sistema valida as credenciais no banco de dados
3. Se válido, cria uma sessão de usuário
4. Em cada página, verifica o tipo de usuário (Admin/Comum)
5. Exibe ou restringe funcionalidades baseado no nível de acesso

## 🤝 Contribuindo

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues ou enviar pull requests.

## 📄 Licença

Este projeto está licenciado sob a Licença MIT.

---

**Desenvolvido com ❤️ para a disciplina de Desenvolvimento Web**

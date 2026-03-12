# ✈️ Sistema de Gerenciamento de Aviões

Projeto desenvolvido para a disciplina de Desenvolvimento Web, com foco em criar um sistema completo de gerenciamento de aviões com diferentes níveis de acesso e permissões.

## 🚀 Acesso ao Projeto

**Link para acesso:** [amirteste.lovestoblog.com]

### 👥 Credenciais de Acesso

**Usuário Admin:**
- Login: admin
- Senha: admin123

**Usuário Comum:**
- Login: douglas
- Senha: user123

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

---

**Desenvolvido com ❤️ para a disciplina de Desenvolvimento Web**

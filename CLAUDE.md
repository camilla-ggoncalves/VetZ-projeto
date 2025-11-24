# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Visao Geral

VetZ e um sistema web de medicina veterinaria e zootecnia desenvolvido em PHP puro com arquitetura MVC. Gerencia usuarios, pets e vacinacoes.

## Stack Tecnologico

- **Backend:** PHP 7+ com OOP, MySQL/MariaDB via PDO
- **Frontend:** HTML5, CSS3, Bootstrap 4, jQuery 3.3.1
- **Infraestrutura:** XAMPP (Apache com mod_rewrite)

## Como Executar

```bash
# 1. Copiar para XAMPP
cp -r VetZ-projeto /path/to/xampp/htdocs/projeto/vetz/

# 2. Criar banco de dados
mysql -u root -e "CREATE DATABASE vetz CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 3. Acessar
open http://localhost/projeto/vetz/
```

**Nao ha scripts npm/yarn** - projeto PHP puro sem build tools.

## Arquitetura

### Estrutura MVC

```
config/           # Conexao PDO MySQL (database_site.php)
controllers/      # Logica de negocio
  PetController.php
  UsuarioController.php
  VacinacaoController.php
models/           # Camada de dados
  Database.php, Pet.php, Usuario.php, Vacinacao.php
public/
  index.php       # Router central com regex para rotas dinamicas
views/            # 22 templates PHP + assets (css/, js/, images/)
uploads/          # Imagens de upload
.htaccess         # URL rewriting
```

### Roteamento

- **Base URL:** `/projeto/vetz/`
- `.htaccess` redireciona para `public/index.php`
- Router usa `preg_match` para rotas dinamicas (`/update-pet/{id}`) e `switch` para rotas fixas

### Banco de Dados

- **Nome:** `vetz` | **Host:** `localhost` | **User:** `root` (sem senha)
- **Tabelas:** usuarios, pets, vacinacao, vacinas

## Rotas Principais

| Tipo | Rota | Funcao |
|------|------|--------|
| POST | `/projeto/vetz/cadastrar` | Registrar usuario |
| POST | `/projeto/vetz/login` | Autenticar |
| GET | `/projeto/vetz/logout` | Logout |
| POST | `/projeto/vetz/save-pet` | Criar pet |
| GET | `/projeto/vetz/list-pet` | Listar pets |
| GET/POST | `/projeto/vetz/update-pet/{id}` | Editar pet |
| POST | `/projeto/vetz/salvar-vacina` | Salvar vacinacao |
| GET | `/projeto/vetz/vacinacao-pet/{id}` | Carteira de vacinacao |

## Convencoes de Codigo

### Nomenclatura
- Controllers: `{Entidade}Controller.php` (PascalCase)
- Models: `{Entidade}.php` (PascalCase)
- Views: `{entidade}_{acao}.php` (snake_case)

### Seguranca
- PDO prepared statements para todas as queries
- `password_hash()` com PASSWORD_DEFAULT
- Sessions PHP para autenticacao
- `htmlspecialchars()` para output escaping

### Padrao Controller
```php
require_once '../models/Pet.php';
class PetController {
    private $petModel;
    public function __construct() {
        $this->petModel = new Pet();
    }
}
```

### Padrao Model
```php
require_once '../config/database_site.php';
class Pet {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
}
```

## Problemas Conhecidos

Documentados em `help_daniel.txt`:
- Cadastro/exibicao de vacinas (vinculacao com pet)
- Cadastro/exibicao de pets no perfil
- Exibicao do perfil do usuario
- Logout do usuario
- **Causa raiz:** Inconsistencias no roteamento URL - necessario padronizar `base_url`

## Dicas de Desenvolvimento

1. Sempre verificar `isset($_SESSION['user_id'])` antes de acessar dados do usuario
2. Imagens salvas em `/uploads/` com nomes aleatorios
3. Todos os links devem usar `/projeto/vetz/` como base
4. Nunca concatenar queries SQL - usar prepared statements

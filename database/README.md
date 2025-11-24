# Banco de Dados VetZ

## Visao Geral

Este diretorio contem o schema do banco de dados MySQL para o projeto VetZ.

## Como Usar

### 1. Criar o Banco de Dados (RECOMENDADO)

**Use o arquivo consolidado que contem TUDO:**

```bash
# Conectar ao MySQL
mysql -u root -p

# Executar o script completo
source /caminho/para/VetZ-projeto/database/schema_completo.sql

# OU via linha de comando direta
mysql -u root -p < database/schema_completo.sql
```

**O arquivo `schema_completo.sql` ja inclui:**
- Estrutura de todas as tabelas
- Todos os campos (incluindo migrations)
- Dados iniciais de vacinas
- Usuario de teste
- Views
- Procedures
- Triggers

### 1.1. Metodo Alternativo (Arquivos Separados)

Se preferir executar em etapas:

```bash
# 1. Criar estrutura basica
mysql -u root -p < database/schema.sql

# 2. (OPCIONAL) Aplicar migrations se necessario
mysql -u root -p < database/migration_add_user_fields.sql
mysql -u root -p < database/migration_add_proxima_dose.sql

# 3. (OPCIONAL) Adicionar procedures
mysql -u root -p < database/procedures.sql

# 4. (OPCIONAL) Adicionar triggers
mysql -u root -p < database/triggers.sql
```

### 2. Configurar Conexao

Edite o arquivo `config/database_site.php` com suas credenciais:

```php
$host = "localhost";
$db_name = "vetz";
$username = "root";
$password = "sua_senha";
```

## Estrutura do Banco

### Tabelas Principais

#### `usuarios`
Armazena os dados dos usuarios/tutores
- `id`: Chave primaria
- `nome`: Nome completo
- `email`: Email unico para login
- `senha`: Hash da senha (PASSWORD_DEFAULT)
- `imagem`: Foto de perfil (opcional)
- `codigo_recuperacao`: Codigo temporario para recuperacao de senha
- `codigo_expira`: Expiracao do codigo de recuperacao

#### `pets`
Armazena os dados dos pets
- `id`: Chave primaria
- `nome`: Nome do pet
- `raca`: Raca do pet
- `idade`: Idade do pet
- `data_nascimento`: Data de nascimento do pet
- `porte`: Pequeno, Medio, Grande
- `peso`: Peso em kg
- `sexo`: Macho, Femea
- `imagem`: Foto do pet
- `id_usuario`: Foreign key para usuarios

#### `registro_vacina`
Catalogo de vacinas disponiveis
- `id_vacina`: Chave primaria
- `vacina`: Nome da vacina
- `descricao`: Descricao detalhada
- `tipo`: Cao, Gato, Ambos

#### `vacinacao`
Registro de vacinacoes aplicadas
- `id`: Chave primaria
- `data_vacinacao`: Data de aplicacao
- `proxima_dose`: Data da proxima dose (opcional)
- `doses`: Numero de doses aplicadas
- `id_vacina`: Foreign key para registro_vacina
- `id_pet`: Foreign key para pets
- `veterinario`: Nome do veterinario (opcional)
- `local`: Local de aplicacao (opcional)
- `observacoes`: Observacoes adicionais (opcional)

## Relacionamentos

```
usuarios (1) -----> (N) pets
pets (1) -----> (N) vacinacao
registro_vacina (1) -----> (N) vacinacao
```

## Views Disponiveis

### `v_vacinacao_por_pet`
Resume o total de vacinas por pet

```sql
SELECT * FROM v_vacinacao_por_pet;
```

### `v_historico_vacinacao`
Historico completo com todos os dados

```sql
SELECT * FROM v_historico_vacinacao WHERE tutor_email = 'email@example.com';
```

## Procedures

### `sp_vacinas_pendentes(pet_id)`
Lista vacinas que precisam de doses adicionais

```sql
CALL sp_vacinas_pendentes(1);
```

### `sp_relatorio_vacinacao(data_inicio, data_fim)`
Relatorio de vacinacoes por periodo

```sql
CALL sp_relatorio_vacinacao('2024-01-01', '2024-12-31');
```

## Dados Iniciais

O script ja inclui:
- 12 vacinas comuns pre-cadastradas
- 1 usuario de teste:
  - Email: `teste@vetz.com`
  - Senha: `senha123`

## Triggers

### `trg_validar_data_vacinacao`
Impede que sejam cadastradas vacinacoes com data futura

## Seguranca

- Todas as senhas sao armazenadas com hash usando `password_hash()` do PHP
- Foreign keys com `ON DELETE CASCADE` para manter integridade referencial
- Indices para otimizar queries comuns
- Validacao de data via trigger

## Manutencao

### Backup

```bash
mysqldump -u root -p vetz > backup_vetz_$(date +%Y%m%d).sql
```

### Restaurar Backup

```bash
mysql -u root -p vetz < backup_vetz_20240101.sql
```

## Queries Uteis

### Listar pets com suas vacinas
```sql
SELECT
    p.nome AS pet,
    rv.vacina,
    v.data_vacinacao,
    v.doses,
    u.nome AS tutor
FROM vacinacao v
INNER JOIN pets p ON v.id_pet = p.id
INNER JOIN registro_vacina rv ON v.id_vacina = rv.id_vacina
INNER JOIN usuarios u ON p.id_usuario = u.id
ORDER BY p.nome, v.data_vacinacao DESC;
```

### Vacinas vencidas (mais de 1 ano)
```sql
SELECT
    p.nome AS pet,
    rv.vacina,
    v.data_vacinacao AS ultima_dose,
    DATEDIFF(CURDATE(), v.data_vacinacao) AS dias_desde_aplicacao
FROM vacinacao v
INNER JOIN pets p ON v.id_pet = p.id
INNER JOIN registro_vacina rv ON v.id_vacina = rv.id_vacina
WHERE v.data_vacinacao < DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
ORDER BY v.data_vacinacao;
```

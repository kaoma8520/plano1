# Motoboy System

Este projeto é um sistema web completo para gerenciamento de pedidos de corridas e entregas com motoboys. O sistema é dividido em três áreas principais: Admin, Motoboy e Cliente, cada uma com suas funcionalidades específicas.

## Estrutura do Projeto

- **admin/**: Área de administração do sistema.
  - `dashboard.php`: Painel principal do administrador.
  - `users.php`: Gerenciamento de usuários (clientes e motoboys).
  - `orders.php`: Visualização de todos os pedidos.
  - `reports.php`: Geração de relatórios financeiros e operacionais.
  - `zones.php`: Controle de zonas de atendimento.
  - `reviews.php`: Gestão das avaliações dos motoboys.
  - `promotions.php`: Criação e gestão de códigos promocionais.
  - `login.php`: Formulário de login para administradores.

- **motoboy/**: Área dedicada aos motoboys.
  - `dashboard.php`: Painel principal do motoboy.
  - `orders.php`: Exibição das corridas atribuídas.
  - `history.php`: Histórico completo de corridas.
  - `availability.php`: Controle de disponibilidade do motoboy.
  - `login.php`: Formulário de login para motoboys.

- **client/**: Área para os clientes.
  - `dashboard.php`: Painel principal do cliente.
  - `new_order.php`: Solicitação de nova corrida.
  - `history.php`: Histórico de corridas do cliente.
  - `review.php`: Avaliação do motoboy.
  - `login.php`: Formulário de login para clientes.

- **api/**: Integrações com APIs externas.
  - `mercado_pago.php`: Integração com a API do Mercado Pago.
  - `whatsapp.php`: Integração com a API do WhatsApp.
  - `google_maps.php`: Cálculo de distâncias e rotas.

- **assets/**: Recursos estáticos do sistema.
  - `css/style.css`: Estilos CSS.
  - `js/main.js`: Scripts JavaScript.
  - `libs/chart.min.js`: Biblioteca para geração de gráficos.

- **config/**: Configurações do sistema.
  - `database.php`: Configurações de conexão com o banco de dados.
  - `config.php`: Configurações gerais do sistema.

- **core/**: Funcionalidades principais do sistema.
  - `session.php`: Gerenciamento de sessões.
  - `auth.php`: Funções de autenticação.
  - `helpers.php`: Funções auxiliares.

- **exports/**: Exportação de dados.
  - `export_pdf.php`: Exportação de relatórios em PDF.
  - `export_csv.php`: Exportação de relatórios em CSV.

- **backup/**: Backup do banco de dados.
  - `daily_backup.sql`: Backup diário.

- **chat/**: Sistema de chat interno.
  - `chat.php`: Implementação do chat.

- **coupons/**: Gerenciamento de cupons de desconto.
  - `validate.php`: Validação de cupons.

- **loyalty/**: Sistema de fidelidade.
  - `points.php`: Gerenciamento de pontos.

- **index.php**: Ponto de entrada do sistema.

- **.htaccess**: Configurações do servidor web.

## Funcionalidades

- **Admin**: Gerenciamento completo do sistema, incluindo usuários, pedidos, relatórios e promoções.
- **Motoboy**: Painel para gerenciar corridas, disponibilidade e histórico.
- **Cliente**: Solicitação de corridas, acompanhamento em tempo real e avaliações.

## Tecnologias Utilizadas

- PHP puro
- MySQL
- HTML5, CSS3 e JavaScript
- Integração com API do Mercado Pago e WhatsApp

## Como Usar

1. Configure o banco de dados no arquivo `config/database.php`.
2. Acesse o sistema através do `index.php`.
3. Utilize as áreas de Admin, Motoboy e Cliente conforme necessário.

## Contribuições

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues ou pull requests.

## Licença

Este projeto é de uso livre.
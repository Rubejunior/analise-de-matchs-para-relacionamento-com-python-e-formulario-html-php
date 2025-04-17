<?php
require_once 'config.php';

// Processar o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $conn = conectarDB();
        
        // Preparar a query SQL
        $stmt = $conn->prepare("INSERT INTO formulario_casamento (
            nome, idade, estado, cidade, bairro, sexo, instagram, telefone, estilo_musical, 
            bebida_alcoolica, tem_filhos, ja_foi_casado, atividade_fisica, 
            idade_minima_parceiro, idade_maxima_parceiro, parceiro_pode_ter_filhos, 
            parceiro_pode_beber, parceiro_pode_ser_casado, frase_identificacao
        ) VALUES (
            :nome, :idade, :estado, :cidade, :bairro, :sexo, :instagram, :telefone, :estilo_musical, 
            :bebida_alcoolica, :tem_filhos, :ja_foi_casado, :atividade_fisica, 
            :idade_minima_parceiro, :idade_maxima_parceiro, :parceiro_pode_ter_filhos, 
            :parceiro_pode_beber, :parceiro_pode_ser_casado, :frase_identificacao
        )");
        
        // Bind dos parâmetros
        $stmt->bindParam(':nome', $_POST['nome']);
        $stmt->bindParam(':idade', $_POST['idade']);
        $stmt->bindParam(':estado', $_POST['estado']);
        $stmt->bindParam(':cidade', $_POST['cidade']);
        $stmt->bindParam(':bairro', $_POST['bairro']);
        $stmt->bindParam(':sexo', $_POST['sexo']);
        $stmt->bindParam(':instagram', $_POST['instagram']);
        $stmt->bindParam(':telefone', $_POST['telefone']);
        $stmt->bindParam(':estilo_musical', $_POST['estilo_musical']);
        $stmt->bindParam(':bebida_alcoolica', $_POST['bebida_alcoolica']);
        $stmt->bindParam(':tem_filhos', $_POST['tem_filhos']);
        $stmt->bindParam(':ja_foi_casado', $_POST['ja_foi_casado']);
        $stmt->bindParam(':atividade_fisica', $_POST['atividade_fisica']);
        $stmt->bindParam(':idade_minima_parceiro', $_POST['idade_minima_parceiro']);
        $stmt->bindParam(':idade_maxima_parceiro', $_POST['idade_maxima_parceiro']);
        $stmt->bindParam(':parceiro_pode_ter_filhos', $_POST['parceiro_pode_ter_filhos']);
        $stmt->bindParam(':parceiro_pode_beber', $_POST['parceiro_pode_beber']);
        $stmt->bindParam(':parceiro_pode_ser_casado', $_POST['parceiro_pode_ser_casado']);
        $stmt->bindParam(':frase_identificacao', $_POST['frase_identificacao']);

        // Executar a query
        $stmt->execute();
        
        $mensagem = "Formulário enviado com sucesso! O Cupido está analisando seu perfil.";
    } catch(PDOException $e) {
        $erro = "Erro ao enviar o formulário: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casamento Na Web com Threds</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        h1, h2, h3 {
            text-align: center;
            color: #d63384;
        }
        
        h1 {
            margin-bottom: 5px;
        }
        
        h2 {
            margin-top: 0;
            font-size: 1.2em;
            color: #666;
        }
        
        h3 {
            font-size: 1em;
            color: #888;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="number"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #d63384;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #c22575;
        }
        
        .mensagem {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        
        .sucesso {
            background-color: #d4edda;
            color: #155724;
        }
        
        .erro {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            
            h1 {
                font-size: 1.5em;
            }
            
            h2 {
                font-size: 1.1em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Casamento Na Web com Threds</h1>
        <h2>Somente para quem deseja relacionamento sério</h2>
        <h3>Só serão selecionados quem preencher corretamente todos itens do formulário</h3>
        
        <?php if (isset($mensagem)): ?>
            <div class="mensagem sucesso"><?php echo $mensagem; ?></div>
        <?php endif; ?>
        
        <?php if (isset($erro)): ?>
            <div class="mensagem erro"><?php echo $erro; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <fieldset>
                <legend>Sobre você</legend>
                
                <div class="form-group">
                    <label for="nome">Nome (Preencher nome e sobrenome)</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                
                <div class="form-group">
                    <label for="idade">Idade</label>
                    <input type="number" id="idade" name="idade" min="18" max="120" required>
                </div>
                
                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado" required onchange="buscarCidades()">
                        <option value="">Selecione seu estado</option>
                        <!-- Estados serão carregados via JavaScript -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="cidade">Cidade:</label>
                    <select id="cidade" name="cidade" required disabled>
                        <option value="">Primeiro selecione o estado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="bairro">Bairro:</label>
                    <input type="text" id="bairro" name="bairro" required>
                </div>
                
                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select id="sexo" name="sexo" required>
                        <option value="Feminino">Feminino</option>
                        <option value="Masculino">Masculino</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="instagram">Seu instagram (Pode ser Link ou @)</label>
                    <input type="text" id="instagram" name="instagram" required>
                </div>
                
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" required>
                </div>
                
                <div class="form-group">
                    <label for="estilo_musical">Estilo musical</label>
                    <select id="estilo_musical" name="estilo_musical" required>
                        <option value="Rock">Rock</option>
                        <option value="MPB">MPB</option>
                        <option value="Sertanejo">Sertanejo</option>
                        <option value="Pop">Pop</option>
                        <option value="Pagode">Pagode</option>
                        <option value="Samba">Samba</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bebida_alcoolica">Bebida Alcoólica</label>
                    <select id="bebida_alcoolica" name="bebida_alcoolica" required>
                        <option value="Não Bebo">Não Bebo</option>
                        <option value="Bebo Socialmente">Bebo Socialmente</option>
                        <option value="Nos Finais de Semana">Nos Finais de Semana</option>
                        <option value="Bebo Sempre">Bebo Sempre</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="tem_filhos">Tem Filhos?</label>
                    <select id="tem_filhos" name="tem_filhos" required>
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="ja_foi_casado">Já foi casado?</label>
                    <select id="ja_foi_casado" name="ja_foi_casado" required>
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="atividade_fisica">Atividade Física</label>
                    <select id="atividade_fisica" name="atividade_fisica" required>
                        <option value="Diariamente">Diariamente</option>
                        <option value="3x por semana">3x por semana</option>
                        <option value="1x por semana">1x por semana</option>
                        <option value="Não gosto">Não gosto</option>
                    </select>
                </div>
            </fieldset>
            
            <fieldset>
                <legend>Quero um Parceiro(a)</legend>
                
                <div class="form-group">
                    <label for="idade_minima_parceiro">Idade mínima</label>
                    <select id="idade_minima_parceiro" name="idade_minima_parceiro" required>
                        <?php for ($i = 18; $i <= 60; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                        <option value="+60">+60</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="idade_maxima_parceiro">Idade máxima</label>
                    <select id="idade_maxima_parceiro" name="idade_maxima_parceiro" required>
                        <?php for ($i = 18; $i <= 60; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                        <option value="+60">+60</option>
                    </select>
                </div>
                
                             <div class="form-group">
                    <label for="parceiro_pode_ter_filhos">Você Se Importa Se Ele(a) Tem Filhos?</label>
                    <select id="parceiro_pode_ter_filhos" name="parceiro_pode_ter_filhos" required>
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                        <option value="Tanto Faz">Tanto Faz</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="parceiro_pode_beber">Você Se Impora Se Ele(a) Consome Bebida Acoólica?</label>
                    <select id="parceiro_pode_beber" name="parceiro_pode_beber" required>
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                        <option value="Tanto Faz">Tanto Faz</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="parceiro_pode_ser_casado">Você Se Impora Se Ele(a) Já Foi Casado?</label>
                    <select id="parceiro_pode_ser_casado" name="parceiro_pode_ser_casado" required>
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                        <option value="Tanto Faz">Tanto Faz</option>
                    </select>
                </div>>
            </fieldset>

            <!-- Adicione este campo no seu formulário, antes do botão de enviar -->
            <div class="form-group">
                <fieldset>
                    <legend>Com qual dessas frases você mais se identifica?</legend>
                    
                    <div class="frase-option">
                        <input type="radio" id="frase1" name="frase_identificacao" value="Vida glamourosa" required>
                        <label for="frase1">"Quero viver entre arranha-céus e champagne, onde o luxo é minha linguagem e a sofisticação meu endereço."</label>
                    </div>
                    
                    <div class="frase-option">
                        <input type="radio" id="frase2" name="frase_identificacao" value="Experiências e viagens">
                        <label for="frase2">"Meu coração bate por experiências - uma mala, passagens aéreas e histórias pra contar são meus maiores tesouros."</label>
                    </div>
                    
                    <div class="frase-option">
                        <input type="radio" id="frase3" name="frase_identificacao" value="Vida simples com família">
                        <label for="frase3">"Sonho com uma casa cheia de risadas, fins de semana no parque e a simplicidade de amar sem hora pra voltar."</label>
                    </div>
                    
                    <div class="frase-option">
                        <input type="radio" id="frase4" name="frase_identificacao" value="Equilíbrio material/espiritual">
                        <label for="frase4">"Busco equilíbrio: conforto material sim, mas sempre com tempo para meditar, ler e conectar-me com o essencial."</label>
                    </div>
                    
                    <div class="frase-option">
                        <input type="radio" id="frase5" name="frase_identificacao" value="Riqueza espiritual">
                        <label for="frase5">"Minha riqueza está no invisível - em conexões profundas, no silêncio que fala e na paz que cultivo diariamente."</label>
                    </div>
                </fieldset>
            </div>

            <style>
            .frase-option {
                margin: 15px 0;
                padding: 10px;
                border: 1px solid #eee;
                border-radius: 5px;
                transition: all 0.3s;
            }

            .frase-option:hover {
                background-color: #f9f9f9;
                border-color: #ddd;
            }

            .frase-option label {
                display: inline;
                margin-left: 10px;
                font-weight: normal;
                cursor: pointer;
            }
            </style>
            
            <button type="submit" class="btn">Enviar Para o Cupido</button>
        </form>
    </div>

    <script>
// Função para carregar os estados ao abrir a página
document.addEventListener('DOMContentLoaded', function() {
    carregarEstados();
});

// Carrega todos os estados do Brasil
async function carregarEstados() {
    try {
        const response = await fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados');
        const estados = await response.json();
        
        const selectEstado = document.getElementById('estado');
        estados.sort((a, b) => a.nome.localeCompare(b.nome)).forEach(estado => {
            const option = document.createElement('option');
            option.value = estado.sigla;
            option.textContent = estado.nome;
            selectEstado.appendChild(option);
        });
    } catch (error) {
        console.error('Erro ao carregar estados:', error);
    }
}

// Busca cidades com base no estado selecionado
async function buscarCidades() {
    const estado = document.getElementById('estado').value;
    const selectCidade = document.getElementById('cidade');
    
    if (!estado) {
        selectCidade.disabled = true;
        selectCidade.innerHTML = '<option value="">Primeiro selecione o estado</option>';
        return;
    }
    
    selectCidade.disabled = true;
    selectCidade.innerHTML = '<option value="">Carregando cidades...</option>';

    try {
        const response = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estado}/municipios`);
        const cidades = await response.json();
        
        selectCidade.innerHTML = '<option value="">Selecione sua cidade</option>';
        cidades.sort((a, b) => a.nome.localeCompare(b.nome)).forEach(cidade => {
            const option = document.createElement('option');
            option.value = cidade.nome;
            option.textContent = cidade.nome;
            selectCidade.appendChild(option);
        });
        
        selectCidade.disabled = false;
    } catch (error) {
        console.error('Erro ao carregar cidades:', error);
        selectCidade.innerHTML = '<option value="">Erro ao carregar cidades</option>';
    }
}
</script>    
</body>

</html>
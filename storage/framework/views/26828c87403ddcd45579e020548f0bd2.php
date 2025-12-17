<?php $__env->startSection('title', 'Escolha o melhor abadá da festa!'); ?>

<?php $__env->startSection('content'); ?>
    <h1>Escolha o melhor abadá da festa!</h1>

    <a href="<?php echo e(route('apuracao.index')); ?>" class="btn-apuracao">📊 Ver Apuração</a>

    <div id="alert-container"></div>

    <?php if(count($funcionarios) > 0): ?>
        <div class="funcionarios-grid">
            <?php $__currentLoopData = $funcionarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $funcionario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="funcionario-card" 
                     data-id="<?php echo e($funcionario['id']); ?>" 
                     data-nome="<?php echo e($funcionario['nomeCompleto']); ?>">
                    <img src="https://api.thalamus.ind.br/storage/<?php echo e($funcionario['path_image']); ?>" 
                         alt="<?php echo e($funcionario['nomeCompleto']); ?>" 
                         class="funcionario-thumb"
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%27150%27 height=%27150%27%3E%3Crect fill=%27%23ddd%27 width=%27150%27 height=%27150%27/%3E%3Ctext fill=%27%23999%27 font-family=%27sans-serif%27 font-size=%2714%27 x=%2750%25%27 y=%2750%25%27 text-anchor=%27middle%27 dy=%27.3em%27%3ESem Foto%3C/text%3E%3C/svg%3E'">
                    <div class="funcionario-nome"><?php echo e($funcionario['nomeCompleto']); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="loading">
            <p>Carregando funcionários...</p>
        </div>
    <?php endif; ?>

    <!-- Modal de Confirmação -->
    <div id="modalConfirmacao" class="modal">
        <div class="modal-content">
            <h2 id="modalTexto"></h2>
            <div class="modal-buttons">
                <button class="btn btn-sim" id="btnConfirmar">Sim</button>
                <button class="btn btn-nao" id="btnCancelar">Não</button>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    let macAddress = '';
    let pessoaSelecionada = null;

    // Função para obter MAC address (tentativa)
    async function obterMacAddress() {
        // Em navegadores web, não é possível obter o MAC address diretamente
        // Vamos usar uma combinação de informações do navegador como identificador único
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        ctx.textBaseline = 'top';
        ctx.font = '14px Arial';
        ctx.fillText('MAC', 2, 2);
        
        const fingerprint = [
            navigator.userAgent,
            navigator.language,
            screen.width + 'x' + screen.height,
            new Date().getTimezoneOffset(),
            canvas.toDataURL()
        ].join('|');

        // Criar hash simples do fingerprint
        let hash = 0;
        for (let i = 0; i < fingerprint.length; i++) {
            const char = fingerprint.charCodeAt(i);
            hash = ((hash << 5) - hash) + char;
            hash = hash & hash;
        }
        
        // Usar localStorage para persistir o identificador
        const storedMac = localStorage.getItem('device_mac');
        if (storedMac) {
            return storedMac;
        }
        
        const deviceId = 'device_' + Math.abs(hash).toString(36);
        localStorage.setItem('device_mac', deviceId);
        return deviceId;
    }

    // Inicializar MAC address ao carregar a página
    obterMacAddress().then(mac => {
        macAddress = mac;
    }).catch(err => {
        console.error('Erro ao obter MAC address:', err);
        // Criar um MAC address de fallback
        macAddress = 'device_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('device_mac', macAddress);
    });

    // Event listeners para os cards de funcionários
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.funcionario-card').forEach(card => {
            card.addEventListener('click', async function() {
                // Garantir que o MAC address está disponível
                if (!macAddress) {
                    macAddress = await obterMacAddress();
                }
                
                const id = this.dataset.id;
                const nome = this.dataset.nome;
                
                pessoaSelecionada = { id, nome };
                
                document.getElementById('modalTexto').textContent = 
                    `Você confirma a escolha de ${nome} como melhor abadá da festa?`;
                document.getElementById('modalConfirmacao').classList.add('active');
            });
        });
    });

    // Botão Cancelar
    document.getElementById('btnCancelar').addEventListener('click', function() {
        document.getElementById('modalConfirmacao').classList.remove('active');
        pessoaSelecionada = null;
    });

    // Botão Confirmar
    document.getElementById('btnConfirmar').addEventListener('click', async function() {
        if (!pessoaSelecionada || !macAddress) {
            mostrarAlerta('Erro ao processar voto. Por favor, recarregue a página.', 'error');
            return;
        }

        this.disabled = true;
        this.textContent = 'Processando...';

        try {
            const response = await fetch('<?php echo e(route("votacao.votar")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    pessoa_id: pessoaSelecionada.id,
                    nome_completo: pessoaSelecionada.nome,
                    mac_address: macAddress
                })
            });

            const data = await response.json();

            if (data.success) {
                mostrarAlerta('Voto registrado com sucesso! Obrigado por participar.', 'success');
                document.getElementById('modalConfirmacao').classList.remove('active');
                
                // Desabilitar todos os cards após votar
                document.querySelectorAll('.funcionario-card').forEach(card => {
                    card.style.opacity = '0.5';
                    card.style.pointerEvents = 'none';
                });
            } else {
                mostrarAlerta(data.message || 'Erro ao registrar voto. Tente novamente.', 'error');
                document.getElementById('modalConfirmacao').classList.remove('active');
            }
        } catch (error) {
            mostrarAlerta('Erro ao conectar com o servidor. Verifique sua conexão.', 'error');
            document.getElementById('modalConfirmacao').classList.remove('active');
        } finally {
            this.disabled = false;
            this.textContent = 'Sim';
        }
    });

    function mostrarAlerta(mensagem, tipo) {
        const alertContainer = document.getElementById('alert-container');
        const alert = document.createElement('div');
        alert.className = `alert alert-${tipo}`;
        alert.textContent = mensagem;
        alertContainer.innerHTML = '';
        alertContainer.appendChild(alert);

        setTimeout(() => {
            alert.remove();
        }, 5000);
    }

    // Fechar modal ao clicar fora
    document.getElementById('modalConfirmacao').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
            pessoaSelecionada = null;
        }
    });
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/darley/votacao/resources/views/votacao/index.blade.php ENDPATH**/ ?>
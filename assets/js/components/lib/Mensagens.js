export default class Mensagens {
    constructor() {
        this.actionMessages = {
            delete: {
                confirm: { 
                    title: "Excluir?",
                    text: "Isso não tem volta!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim, Excluir!",
                    cancelButtonText: "Cancelar"
                },
                success: { 
                    title: "Excluído!",
                    text: "Excluído com sucesso.",
                    icon: "success"
                }
            },
            create: {
                confirm: { 
                    title: "Cadastrar?",
                    text: "Deseja cadastrar este item?",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim, Cadastrar!",
                    cancelButtonText: "Cancelar"
                },
                success: { 
                    title: "Cadastrado!",
                    text: "Cadastrado com sucesso.",
                    icon: "success"
                }
            },
            update: {
                confirm: { 
                    title: "Atualizar?",
                    text: "Deseja atualizar este item?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim, Atualizar!",
                    cancelButtonText: "Cancelar"
                },
                success: { 
                    title: "Atualizado!",
                    text: "Atualizado com sucesso.",
                    icon: "success"
                }
            }
        };
    }

    async confirmAction(action) {
        const messages = this.actionMessages[action];
        if (!messages) {
            console.error("Ação desconhecida:", action);
            return false;
        }

        const result = await Swal.fire(messages.confirm);
        return result.isConfirmed;
    }
}

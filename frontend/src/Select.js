import React, {Component} from "react";

//Компонент вападающего списка.
// Источник данных а пропсах:props.url.
// Данные отдаются через props.updateState
export default class Select extends Component{

    constructor(props) {
        super(props);
        this.state = {
            items:[]
        };
    }

    componentDidMount(){//Получить данные для списка

        const init = {
            method: 'GET',
            headers:{
                'Content-Type': 'application/json'
            }
        };

        fetch( this.props.url, init).then(res =>res.json()).then(json =>{

            const items = json.map( obj =>{ return obj});
            this.setState({items:items});//запихнуть данные в местный стейт
            const item = items[0];
            this.props.updateState(this.props.keyname, item);//выставить данные в главном стейте, чтобы не ушла пустая строка
        })
    }
    /*
    Обработчик выбора в списке
     */
   onChangeHandler = (e) => {

        const val = e.target.options[e.target.selectedIndex].value;

        const keyname = this.props.keyname;

        this.props.updateState(keyname, val);
    }

    render(){
       //список Option для списка
        const options = this.state.items.reduce( (arr, id, idx) =>{
            arr.push( (<option value={id} key={idx}>{id}</option>));
            return arr;
        }, []);

        return(
            <select size='1' onChange={this.onChangeHandler}>
                {options}
            </select>
        )
    }
}
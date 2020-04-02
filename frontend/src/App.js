import React, {Component} from 'react';
import logo from './logo.svg';
import './App.scss';
import './Row';
import Row from "./Row";
import Select from './Select'
import {ValuteIdList, DateList, Api} from "./config";

//все приложение
export default class App extends Component{

    constructor(props){
        super(props);
        this.state={
            rows:[],
            valuteId:undefined,
            startDate:undefined,
            endDate:undefined,
            error:undefined
        }
    }

    //передается в низлежащие компоненты
    updateState = ( key, value) =>{
        let state = this.state;
        state[key] = value;
        this.setState(state);
    }

    //получение данных от Api
    getData = () =>{

        //id валюты
        const valuteId = this.state.valuteId;

        //адрес api
        let path = Api +  "/" + valuteId + "/";
        path += this.state.startDate ? (this.state.startDate + "/") : "";
        path += this.state.endDate ? this.state.endDate : '';


        const init = {
            method: 'GET',
            headers:{
                'Content-Type': 'application/json'
            }
        };

        fetch( path, init).then(res =>res.json()).then(json =>{
            this.setState({rows:json});
        })
    }

    render(){

    const rows = this.state.rows.reduce((arr, data) =>{
        const str = (<Row data={data} key={data.id}/>);
        arr.push(str);
        return arr;
    }, []);

    return (
        <div className="App">
          <header className="App-header">
              <div className="row text-md-right m-md-3">
                  <div className="col-md-2">Id валюты:</div>
                  <Select className="col-md-1 " url={ValuteIdList} keyname='valuteId' updateState={this.updateState}/>
                  <div className="col-md-2">Начальная дата:</div>
                  <Select className="col-md-1 " url={DateList} keyname='startDate' updateState={this.updateState}/>
                  <div className="col-md-2">Конечная дата:</div>
                  <Select className="col-md-1 " url={DateList} keyname='endDate' updateState={this.updateState}/>
                  <button className="offset-md-1 col-md-1 " onClick={this.getData}>Показать</button>
              </div>
          </header>
            <div className='container'>
                <div className='alert'>{this.state.error}</div>
                <div className="row border-bottom">
                    <div className="valuteId col-md-3">Id валюты:</div>
                    <div className="numCode col-md-2">Числовой код:</div>
                    <div className="charCode col-md-2">Символьный код</div>
                    <div className="value col-md-3">Значение</div>
                    <div className="datecol-md-2">Дата</div>
                </div>
                {rows}
            </div>
        </div>
    );
  }
}

import React from "react";

//Компонент отрисовки строки данных
//данные в props.data
export default function Row(props) {
    return(
        <div className="row">
            <div className="valuteId col-md-3">{props.data.valuteID}</div>
            <div className="numCode col-md-2">{props.data.numCode}</div>
            <div className="charCode col-md-2">{props.data.charCode}</div>
            <div className="value col-md-3">{props.data.value}</div>
            <div className="datecol-md-2">{props.data.date}</div>
        </div>
    )
}
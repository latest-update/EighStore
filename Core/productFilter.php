<?php 

function PrintParams($type){
    switch($type){
        case 'Лампы':
            return 'let filterWords = {"Cocol": "Цоколь", "protection": "Степень защиты", "lightemp": "Цветовая температура", "voltage": "Напряжение"};'; 
        break;
        default:
            return 'let filterWords = {"voltage": "Напряжение"};';
            break;
    }
}

function PrintFilterElems($type){
    switch($type){
        case 'Лампы':
            return '<div class="column">
                        <div class="filters-part column">
                        
                            <div class="filter-name"><p><strong>Цоколь</strong></p></div>
                            <div class="filter-body">
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="Cocol" value="E27">
                                    <p>E27</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="Cocol" value="E28">
                                    <p>E28</p>
                                    
                                </div>
                                
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="Cocol" value="E5">
                                    <p>E5</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="Cocol" value="E14">
                                    <p>E14</p>
                                    
                                </div>
                                
                                
                                
                            </div>
                    
                            </div>
                            
                        <div class="filters-part column">
                        
                            <div class="filter-name"><p><strong>Степень защиты</strong></p></div>
                            <div class="filter-body">
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="protection" value="IP20">
                                    <p>IP20</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="protection" value="IP44">
                                    <p>IP44</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="protection" value="IP55">
                                    <p>IP55</p>
                                    
                                </div>
                                
                            </div>
                    
                        </div> 
                            
                        </div>
                    
                        
                        <div class="column">
                    
                            <div class="filters-part3 column">
                        
                            <div class="filter-name"><p><strong>Напряжение, V</strong></p></div>
                            <div class="filter-body">
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="voltage" value="220В">
                                    <p>220В</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="voltage" value="12В">
                                    <p>12В</p>
                                    
                                </div>
                                
                            </div>
                    
                            </div>
                            
                            <div class="filters-part2 column">
                        
                            <div class="filter-name"><p><strong>Цветовая температура, K</strong></p></div>
                            <div class="filter-body">
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="lightemp" value="2700K">
                                    <p>2700K</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="lightemp" value="4000K">
                                    <p>4000K</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="lightemp" value="6000K">
                                    <p>6000K</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="lightemp" value="6500K">
                                    <p>6500K</p>
                                    
                                </div>
                                
                            </div>
                    
                        </div> 
                            
                            
                            
                        
                        </div>'; 
        break;
            
        default:
            return '
            
            <div class="column">
                <div class="filters-part3 column">
                        
                            <div class="filter-name"><p><strong>Напряжение, V</strong></p></div>
                            <div class="filter-body">
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="voltage" value="220В">
                                    <p>220В</p>
                                    
                                </div>
                                <div class="filter-checkbox row-start pos-center">
                                
                                    <input type="checkbox" class="filter-checkbox-input" name="voltage" value="12В">
                                    <p>12В</p>
                                    
                                </div>
                                
                            </div>
                    
                            </div>
            </div>
            
            ';
            break;
    }
}
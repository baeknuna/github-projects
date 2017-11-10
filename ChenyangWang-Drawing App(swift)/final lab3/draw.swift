//
//  draw.swift
//  final lab3
//
//  Created by 王琛阳 on 9/27/16.
//  Copyright © 2016 王琛阳. All rights reserved.
//

import UIKit

class draw: UIView {
    //var currPath: draw? = nil
    var curPath = UIBezierPath()
    var size:CGFloat = 5
    var undo: Bool = false
    var color: UIColor = UIColor.blackColor()
    var arrayOfPoints: [CGPoint] = [CGPoint]() {
        didSet {
            setNeedsDisplay()
        }
    }
    
    
    
    
    //let circlePath = UIBezierPath(arcCenter: CGPoint(x: 100,y: 100), radius: CGFloat(20), startAngle: CGFloat(0), endAngle:CGFloat(M_PI * 2), clockwise: true)
    // func drawRect(rect: CGRect){
    //  UIColor.greenColor().setFill()
    //let circleRadius: CGFloat = self.bounds.height/2
    // let path = UIBezierPath()
    // }
    
    
    // override func touchesMoved(touches: Set<UITouch>, withEvent event: UIEvent?) {
    
    //let newPoint = touch.locationInView(self)
    
    //lines.append(Line(start: lastPoint, end: newPoint))
    // lastPoint = newPoint
    //self.setNeedsDisplay()
    //}
   
    
    private func findMidpoint(firstPoint: CGPoint, secondPoint: CGPoint) -> CGPoint {
        // implement this function here
        let mid = CGPoint(x: (secondPoint.x + firstPoint.x)/2, y: (secondPoint.y + firstPoint.y)/2)
        return mid
    }
    func createQuadPath(arrayOfPoints: [CGPoint]) -> UIBezierPath {
        
        //UIColor.greenColor().set()
        let arrayOfPoints = arrayOfPoints
        let newPath = UIBezierPath()
        newPath.lineWidth = size
        
        if (arrayOfPoints.isEmpty == true){
            return newPath
        }
        
        let firstLocation = arrayOfPoints[0]
        newPath.moveToPoint(firstLocation)
        if arrayOfPoints.count == 1 {
            return newPath
        }
        if arrayOfPoints.count == 2 {
            newPath.addArcWithCenter(firstLocation, radius: newPath.lineWidth, startAngle: 0, endAngle: CGFloat(M_PI * 2), clockwise: true)
            return newPath
        }
        
        
        let secondLocation = arrayOfPoints[1]
        let firstMidpoint = findMidpoint(firstLocation, secondPoint: secondLocation)
        newPath.addLineToPoint(firstMidpoint)
        for index in 1 ..< arrayOfPoints.count-1 {
            let currentLocation = arrayOfPoints[index]
            let nextLocation = arrayOfPoints[index + 1]
            let midpoint = findMidpoint(currentLocation, secondPoint: nextLocation)
            newPath.addQuadCurveToPoint(midpoint, controlPoint: currentLocation)
        }
        let lastLocation = arrayOfPoints.last
        newPath.addLineToPoint(lastLocation!)
        //newPath.closePath()
        return newPath
    }
    override func drawRect(rect: CGRect) {
        curPath = createQuadPath(arrayOfPoints)
        //curPath.backgroundColor = UIColor.clrearColor()
        UIColor.clearColor().setFill()
        color.setStroke()
        //currPath!.size=size
        curPath.stroke()
        curPath.fill()
        self.setNeedsDisplay()
        
    }
    //func remove(){
     //   if undo == true{
            
      //  curPath.removeAllPoints()
     //       }

   // }
    
    
}




